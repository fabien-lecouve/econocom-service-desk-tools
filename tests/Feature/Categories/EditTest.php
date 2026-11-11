
<?php

use App\Models\Category;
use App\Models\Color;
use App\Models\Project;
use App\Models\ProjectCategoryColorSetting;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\ColorSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->project = Project::factory()->create();

    $this->category = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
    ]);

    $this->actingAs($this->user);
});


// AUTH - 200
test('admin can access edit page', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(200);
    $response->assertViewIs('categories.edit');
});

test('authorized project roles can access edit page', function ($roleCode) {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', $roleCode)->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(200);
})->with([
    'technician',
    'technician_referent',
    'technical_coordinator',
]);


// AUTH - 403
test('reader cannot access edit page', function () {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', 'reader')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(403);
});

test('external user cannot access edit page', function () {
    $this->seed(RoleSeeder::class);

    $projectB = Project::factory()->create();
    $role = Role::where('code', 'technician')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $projectB->id,
        'role_id' => $role->id,
    ]);

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(403);
});


// AUTH - 302
test('unauthenticated visitor is redirected to login', function () {
    auth()->logout();

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertRedirect(route('login'));
});


// DATA
test('selected category is passed to the view', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(200);

    $response->assertViewHas('project', fn ($project) =>
        $project->id === $this->project->id
    );

    $response->assertViewHas('category', fn ($category) =>
        $category->id === $this->category->id
    );
});

test('only project root categories are retrieved with their children', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $projectB = Project::factory()->create();

    $child = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => $this->category->id,
        'label' => 'child',
    ]);

    $categoryB = Category::factory()->create([
        'project_id' => $projectB->id,
        'parent_id' => null,
        'label' => 'categoryB',
    ]);

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(200);

    $response->assertViewHas('categories', fn ($categories) =>
        $categories->contains('id', $this->category->id)
        && $categories->doesntContain('id', $child->id)
        && $categories->doesntContain('id', $categoryB->id)
        && $categories->firstWhere('id', $this->category->id)
            ->children->contains('id', $child->id)
    );
});

test('root categories are retrieved in position order', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $this->category->update(['position' => 3]);

    $category2 = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
        'position' => 1,
    ]);

    $category3 = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
        'position' => 2,
    ]);

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(200);

    $response->assertViewHas('categories', fn ($categories) =>
        $categories->pluck('id')->all() === [
            $category2->id,
            $category3->id,
            $this->category->id,
        ]
    );
});

test('colors are retrieved in position order', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $this->seed(ColorSeeder::class);

    $expectedIds = Color::orderBy('position')->pluck('id')->all();

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(200);

    $response->assertViewHas('colors', fn ($colors) =>
        $colors->pluck('id')->all() === $expectedIds
    );
});

test('project category color settings are retrieved with their colors', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $this->seed(ColorSeeder::class);

    $colors = Color::orderBy('id')->take(3)->get();

    $setting = ProjectCategoryColorSetting::create([
        'project_id' => $this->project->id,
        'font_color_id' => $colors[0]->id,
        'background_color_id' => $colors[1]->id,
        'border_top_color_id' => $colors[2]->id,
    ]);

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $this->category])
    );

    $response->assertStatus(200);

    $response->assertViewHas('categoryTypeColorSetting', fn ($result) =>
        $result->id === $setting->id
        && $result->fontColor->id === $setting->font_color_id
        && $result->backgroundColor->id === $setting->background_color_id
        && $result->borderTopColor->id === $setting->border_top_color_id
    );
});


// SECURITY
test('category from another project cannot be edited through current project', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $projectB = Project::factory()->create();

    $categoryB = Category::factory()->create([
        'project_id' => $projectB->id,
    ]);

    $response = $this->get(
        route('projects.categories.edit', [$this->project, $categoryB])
    );

    $response->assertStatus(404);
});
