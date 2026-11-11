
<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->project = Project::factory()->create();

    $this->category = Category::factory()->create([
        'project_id' => $this->project->id,
        'label' => 'category1',
        'parent_id' => null,
    ]);

    $this->actingAs($this->user);
});


// 302
test('admin can destroy a category', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->delete(
        route('projects.categories.destroy', [$this->project, $this->category])
    );

    $response->assertRedirect(route('projects.categories.index', $this->project));

    $this->assertSoftDeleted('categories', [
        'id' => $this->category->id,
    ]);
});

test('authorized project roles can destroy a category', function ($roleCode) {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', $roleCode)->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->delete(
        route('projects.categories.destroy', [$this->project, $this->category])
    );

    $response->assertRedirect(route('projects.categories.index', $this->project));

    $this->assertSoftDeleted('categories', [
        'id' => $this->category->id,
    ]);
})->with([
    'technician_referent',
    'technical_coordinator',
]);


// 403
test('unauthorized project roles cannot destroy a category', function ($roleCode) {
    $this->seed(RoleSeeder::class);

    $role = Role::where('code', $roleCode)->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->delete(
        route('projects.categories.destroy', [$this->project, $this->category])
    );

    $response->assertStatus(403);

    $this->assertNotSoftDeleted('categories', [
        'id' => $this->category->id,
    ]);
})->with([
    'technician',
    'reader',
]);

test('external user cannot destroy a category', function () {
    $this->seed(RoleSeeder::class);

    $projectB = Project::factory()->create();
    $role = Role::where('code', 'technician_referent')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $projectB->id,
        'role_id' => $role->id,
    ]);

    $response = $this->delete(
        route('projects.categories.destroy', [$this->project, $this->category])
    );

    $response->assertStatus(403);

    $this->assertNotSoftDeleted('categories', [
        'id' => $this->category->id,
    ]);
});


// 302
test('unauthenticated visitor is redirected to login', function () {
    auth()->logout();

    $response = $this->delete(
        route('projects.categories.destroy', [$this->project, $this->category])
    );

    $response->assertRedirect(route('login'));

    $this->assertNotSoftDeleted('categories', [
        'id' => $this->category->id,
    ]);
});


// DATA
test('a category is soft deleted successfully', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->delete(
        route('projects.categories.destroy', [$this->project, $this->category])
    );

    $response->assertRedirect(route('projects.categories.index', $this->project));

    $response->assertSessionHas(
        'success',
        'La catégorie "category1" a été supprimée'
    );

    $this->assertSoftDeleted('categories', [
        'id' => $this->category->id,
    ]);

    expect(Category::find($this->category->id))->toBeNull();

    expect(Category::withTrashed()->find($this->category->id))
        ->not->toBeNull();
});


// SECURITY
test('category from another project cannot be destroyed through current project', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $projectB = Project::factory()->create();

    $categoryB = Category::factory()->create([
        'project_id' => $projectB->id,
        'label' => 'categoryB',
    ]);

    $response = $this->delete(
        route('projects.categories.destroy', [$this->project, $categoryB])
    );

    $response->assertStatus(404);

    $this->assertNotSoftDeleted('categories', [
        'id' => $categoryB->id,
    ]);
});
