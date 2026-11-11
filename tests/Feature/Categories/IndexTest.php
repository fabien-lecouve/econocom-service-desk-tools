<?php

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


beforeEach(function () {
    $this->user = User::factory()->create();
    $this->project = Project::factory()->create();

    $this->actingAs($this->user);
});


// 200
test('admin can access index page', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $response = $this->get(route('projects.categories.index', $this->project));
    $response->assertStatus(200);
});

test('a project member can access index page', function () {
    $this->seed(RoleSeeder::class);
    $role = Role::where('code', 'reader')->firstOrFail();

    $this->user->memberships()->create([
        'project_id' => $this->project->id,
        'role_id' => $role->id,
    ]);

    $response = $this->get(route('projects.categories.index', $this->project));
    $response->assertStatus(200);
});


// 403
test('a user who isn\'t part of the project can\'t access index page', function () {
    $response = $this->get(route('projects.categories.index', $this->project));
    $response->assertStatus(403);
});


// 302
test('an unauthenticated visitor is redirected to the login', function () {
    auth()->logout();

    $response = $this->get(route('projects.categories.index', $this->project));
    $response->assertRedirect(route('login'));
});


// DATA
test('only the project\'s categories are retrieved', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $category = $this->project->categories()->create([
        'code' => 'cat--001',
        'label' => 'category',
        'position' => 1
    ]);

    $projectB = Project::factory()->create();
    $categoryB = $projectB->categories()->create([
        'code' => 'cat--002',
        'label' => 'categoryB',
        'position' => 1
    ]);

    $response = $this->get(route('projects.categories.index', $this->project));

    $response->assertViewHas('categories', function ($categories) use ($category, $categoryB) {
            return $categories->contains('id', $category->id)
                && $categories->doesntContain('id', $categoryB->id);
        });

    $response->assertSeeText('category');
    $response->assertDontSeeText('categoryB');
});

test('the parent categories are retrieved with their children', function () {
    $this->user->forceFill(['is_admin' => true])->save();

    $parent = $this->project->categories()->create([
        'code' => 'cat--001',
        'label' => 'parent',
        'position' => 1
    ]);

    $child = $this->project->categories()->create([
        'code' => 'cat--011',
        'label' => 'child',
        'position' => 1,
        'parent_id' => $parent->id
    ]);

    $response = $this->get(route('projects.categories.index', $this->project));

    $response->assertViewHas('categories', function ($categories) use ($parent, $child) {
            return $categories->contains('id', $parent->id)
                && $categories->doesntContain('id', $child->id)
                && $categories->firstWhere('id', $parent->id)
                    ->children->contains('id', $child->id);
        });

    $response->assertSeeText('child');
});

test('the categories are ordered by position', function () {
   $this->user->forceFill(['is_admin' => true])->save();

    $category2 = $this->project->categories()->create([
        'code' => 'cat--002',
        'label' => 'category2',
        'position' => 2,
    ]);

    $category1 = $this->project->categories()->create([
        'code' => 'cat--001',
        'label' => 'category1',
        'position' => 1,
    ]);

    $response = $this->get(route('projects.categories.index', $this->project));

    $response->assertStatus(200);

    $response->assertViewHas('categories', function ($categories) use ($category1, $category2) {
        return $categories->pluck('id')->all() === [
            $category1->id,
            $category2->id,
        ];
    });
});