<?php

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

    $this->actingAs($this->user);
});


// 200
test('admin can access create page', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->get(route('projects.categories.create', $this->project));
    $response->assertStatus(200);
});

test('authorized project roles can access create page', function ($roleCode) {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', $roleCode)->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->get(
        route('projects.categories.create', $this->project)
    );

    $response->assertStatus(200);
        })->with([
            'technician',
            'technician_referent',
            'technical_coordinator',
]);


// 403
test('reader can\'t access create page', function () {
    $this->seed(RoleSeeder::class);
    $role = Role::where('code', 'reader')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->get(route('projects.categories.create', $this->project));
    $response->assertStatus(403);
});

test('external user to the project can\'t access create page', function () {
    $this->seed(RoleSeeder::class);
    $role = Role::where('code', 'technician')->firstOrFail();
    $projectB = Project::factory()->create();

    $this->user->memberships()->create([
        'project_id' => $projectB->id,
        'role_id' => $role->id,
    ]);

    $response = $this->get(route('projects.categories.create', $this->project));
    $response->assertStatus(403);
});


// 302
test('an unauthenticated visitor is redirected to the login', function () {
    auth()->logout();

    $response = $this->get(route('projects.categories.create', $this->project));
    $response->assertRedirect(route('login'));
});


// DATA
test('only the project categories are retrieved with their children', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $parent = $this->project->categories()->create([
        'code' => 'cat-a--001',
        'label' => 'parent',
        'position' => 1
    ]);
    $child = $this->project->categories()->create([
        'code' => 'cat-a--011',
        'label' => 'child',
        'position' => 1,
        'parent_id' => $parent->id
    ]);

    $projectB = Project::factory()->create();
    $categoryB = $projectB->categories()->create([
        'code' => 'cat-b--002',
        'label' => 'categoryB',
        'position' => 1
    ]);

    $response = $this->get(route('projects.categories.create', $this->project));

    $response->assertViewHas('categories', function ($categories) use ($parent, $child, $categoryB) {
            return $categories->contains('id', $parent->id)
                && $categories->doesntContain('id', $categoryB->id)
                && $categories->doesntContain('id', $child->id)
                && $categories->firstWhere('id', $parent->id)
                    ->children->contains('id', $child->id);
        });

    $response->assertSeeText('parent');
    $response->assertDontSeeText('categoryB');
});

test('colors are retrieved in position order', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $this->seed(ColorSeeder::class);

    $expectedIds = Color::orderBy('position')
        ->pluck('id')
        ->all();

    $response = $this->get(route('projects.categories.create', $this->project));

    $response->assertStatus(200);

    $response->assertViewHas('colors', function ($colors) use ($expectedIds) {
        return $colors->pluck('id')->all() === $expectedIds;
    });
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

    $response = $this->get(route('projects.categories.create', $this->project));

    $response->assertStatus(200);

    $response->assertViewHas('categoryTypeColorSetting', function ($result) use ($setting) {
        return $result->id === $setting->id
            && $result->fontColor->id === $setting->font_color_id
            && $result->backgroundColor->id === $setting->background_color_id
            && $result->borderTopColor->id === $setting->border_top_color_id;
    });
});