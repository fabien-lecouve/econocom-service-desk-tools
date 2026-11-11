
<?php

use App\Models\Category;
use App\Models\Color;
use App\Models\Project;
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
        'label' => 'category1',
    ]);

    $this->actingAs($this->user);

    $this->data = [
        'label' => 'category2',
        'parent_id' => null,
        'font_color_id' => null,
        'background_color_id' => null,
        'border_top_color_id' => null,
    ];
});


// 200
test('admin can update a category', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $this->data
    );

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('projects.categories.index', $this->project));

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category2',
    ]);
});

test('authorized project roles can update a category', function ($roleCode) {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', $roleCode)->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $this->data
    );

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('projects.categories.index', $this->project));

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category2',
    ]);
})->with([
    'technician',
    'technician_referent',
    'technical_coordinator',
]);


// 403
test('reader cannot update a category', function () {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', 'reader')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $this->data
    );

    $response->assertStatus(403);

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category1',
    ]);
});

test('external user cannot update a category', function () {
    $this->seed(RoleSeeder::class);

    $projectB = Project::factory()->create();
    $role = Role::where('code', 'technician')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $projectB->id,
        'role_id' => $role->id,
    ]);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $this->data
    );

    $response->assertStatus(403);

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category1',
    ]);
});


// 302
test('unauthenticated visitor is redirected to login', function () {
    auth()->logout();

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $this->data
    );

    $response->assertRedirect(route('login'));

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category1',
    ]);
});


// DATA
test('a category is updated with valid data', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $this->data
    );

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('projects.categories.index', $this->project));
    $response->assertSessionHas(
        'success',
        'La catégorie "category2" a été modifiée'
    );

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'project_id' => $this->project->id,
        'parent_id' => null,
        'label' => 'category2',
    ]);

    $this->assertDatabaseMissing('categories', [
        'id' => $this->category->id,
        'label' => 'category1',
    ]);
});

test('a category can be assigned to a parent', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $parent = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
    ]);

    $data = array_merge($this->data, [
        'parent_id' => $parent->id,
    ]);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $data
    );

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'parent_id' => $parent->id,
    ]);
});

test('category colors are updated correctly', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $this->seed(ColorSeeder::class);

    $colors = Color::orderBy('id')->take(3)->get();

    $data = array_merge($this->data, [
        'font_color_id' => $colors[0]->id,
        'background_color_id' => $colors[1]->id,
        'border_top_color_id' => $colors[2]->id,
    ]);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $data
    );

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category2',
        'font_color_id' => $data['font_color_id'],
        'background_color_id' => $data['background_color_id'],
        'border_top_color_id' => $data['border_top_color_id'],
    ]);
});


// VALIDATION
test('invalid category data is rejected', function ($field, $value) {
    $this->user->forceFill(['is_admin' => true])->save();

    $data = $this->data;
    $data[$field] = $value;

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $data
    );

    $response->assertSessionHasErrors($field);

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category1',
    ]);
})->with([
    'empty label' => ['label', ''],
    'label too long' => ['label', str_repeat('a', 101)],
    'invalid label type' => ['label', ['invalid']],
    'invalid parent type' => ['parent_id', 'invalid'],
    'unknown parent' => ['parent_id', 999999],
    'invalid font color type' => ['font_color_id', 'invalid'],
    'unknown font color' => ['font_color_id', 999999],
    'invalid background color type' => ['background_color_id', 'invalid'],
    'unknown background color' => ['background_color_id', 999999],
    'invalid border top color type' => ['border_top_color_id', 'invalid'],
    'unknown border top color' => ['border_top_color_id', 999999],
]);

test('missing category label is rejected', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $data = $this->data;
    unset($data['label']);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $data
    );

    $response->assertSessionHasErrors('label');

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category1',
    ]);
});

test('a category cannot have a parent from another project', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $projectB = Project::factory()->create();

    $parent = Category::factory()->create([
        'project_id' => $projectB->id,
    ]);

    $data = array_merge($this->data, [
        'parent_id' => $parent->id,
    ]);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $this->category]),
        $data
    );

    $response->assertSessionHasErrors('parent_id');

    $this->assertDatabaseHas('categories', [
        'id' => $this->category->id,
        'label' => 'category1',
        'parent_id' => null,
    ]);
});


// SECURITY
test('category from another project cannot be updated through current project', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $projectB = Project::factory()->create();

    $categoryB = Category::factory()->create([
        'project_id' => $projectB->id,
        'label' => 'categoryB',
    ]);

    $response = $this->put(
        route('projects.categories.update', [$this->project, $categoryB]),
        $this->data
    );

    $response->assertStatus(404);

    $this->assertDatabaseHas('categories', [
        'id' => $categoryB->id,
        'label' => 'categoryB',
    ]);
});
