
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

    $this->actingAs($this->user);

    $this->data = [
        'label' => 'category1',
        'parent_id' => null,
        'font_color_id' => null,
        'background_color_id' => null,
        'border_top_color_id' => null,
    ];
});


// 200
test('admin can store a category', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $this->data
    );

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('projects.categories.index', $this->project));

    $this->assertDatabaseHas('categories', [
        'project_id' => $this->project->id,
        'label' => 'category1',
    ]);
});

test('authorized project roles can store a category', function ($roleCode) {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', $roleCode)->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $this->data
    );

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('projects.categories.index', $this->project));

    $this->assertDatabaseHas('categories', [
        'project_id' => $this->project->id,
        'label' => 'category1',
    ]);
})->with([
    'technician',
    'technician_referent',
    'technical_coordinator',
]);


// 403
test('reader cannot store a category', function () {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', 'reader')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $this->data
    );

    $response->assertStatus(403);

    $this->assertDatabaseMissing('categories', [
        'project_id' => $this->project->id,
        'label' => 'category1',
    ]);
});

test('external user cannot store a category', function () {
    $this->seed(RoleSeeder::class);

    $projectB = Project::factory()->create();
    $role = Role::where('code', 'technician')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $projectB->id,
        'role_id' => $role->id,
    ]);

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $this->data
    );

    $response->assertStatus(403);

    $this->assertDatabaseMissing('categories', [
        'project_id' => $this->project->id,
        'label' => 'category1',
    ]);
});


// 302
test('unauthenticated visitor is redirected to login', function () {
    auth()->logout();

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $this->data
    );

    $response->assertRedirect(route('login'));

    $this->assertDatabaseMissing('categories', [
        'project_id' => $this->project->id,
        'label' => 'category1',
    ]);
});


// DATA
test('a category is created with valid data', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $this->data
    );

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('projects.categories.index', $this->project));
    $response->assertSessionHas(
        'success',
        'La catégorie "category1" a été créée'
    );

    $this->assertDatabaseHas('categories', [
        'project_id' => $this->project->id,
        'parent_id' => null,
        'label' => 'category1',
        'code' => "{$this->project->code}-cat-001",
        'position' => 1,
    ]);
});

test('a child category is associated with its parent', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $parent = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
    ]);

    $data = array_merge($this->data, [
        'label' => 'child',
        'parent_id' => $parent->id,
    ]);

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $data
    );

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'project_id' => $this->project->id,
        'parent_id' => $parent->id,
        'label' => 'child',
    ]);
});

test('category colors are saved correctly', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $this->seed(ColorSeeder::class);

    $colors = Color::orderBy('id')->take(3)->get();

    $data = array_merge($this->data, [
        'font_color_id' => $colors[0]->id,
        'background_color_id' => $colors[1]->id,
        'border_top_color_id' => $colors[2]->id,
    ]);

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $data
    );

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'project_id' => $this->project->id,
        'label' => 'category1',
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

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $data
    );

    $response->assertSessionHasErrors($field);

    $this->assertDatabaseCount('categories', 0);
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

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $data
    );

    $response->assertSessionHasErrors('label');

    $this->assertDatabaseCount('categories', 0);
});

test('a category cannot have a parent from another project', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $projectB = Project::factory()->create();

    $parent = Category::factory()->create([
        'project_id' => $projectB->id,
        'parent_id' => null,
    ]);

    $data = array_merge($this->data, [
        'parent_id' => $parent->id,
    ]);

    $response = $this->post(
        route('projects.categories.store', $this->project),
        $data
    );

    $response->assertSessionHasErrors('parent_id');

    $this->assertDatabaseMissing('categories', [
        'project_id' => $this->project->id,
        'label' => 'category1',
    ]);
});
