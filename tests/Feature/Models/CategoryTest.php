
<?php

use App\Models\Category;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->project = Project::factory()->create();
});


// GENERATE CODE
test('first category code starts at 001', function () {
    $code = Category::generateCode($this->project);

    expect($code)->toBe("{$this->project->code}-cat-001");
});

test('category code increments correctly', function () {
    Category::factory()->create([
        'project_id' => $this->project->id,
        'code' => "{$this->project->code}-cat-001",
    ]);

    $code = Category::generateCode($this->project);

    expect($code)->toBe("{$this->project->code}-cat-002");
});

test('category codes are independent for each project', function () {
    $projectB = Project::factory()->create();

    Category::factory()->create([
        'project_id' => $this->project->id,
        'code' => "{$this->project->code}-cat-005",
    ]);

    expect(Category::generateCode($this->project))
        ->toBe("{$this->project->code}-cat-006");

    expect(Category::generateCode($projectB))
        ->toBe("{$projectB->code}-cat-001");
});

test('soft deleted categories are included when generating codes', function () {
    $category = Category::factory()->create([
        'project_id' => $this->project->id,
        'code' => "{$this->project->code}-cat-005",
    ]);

    $category->delete();

    $code = Category::generateCode($this->project);

    expect($code)->toBe("{$this->project->code}-cat-006");
});

test('category code increments from 099 to 100', function () {
    Category::factory()->create([
        'project_id' => $this->project->id,
        'code' => "{$this->project->code}-cat-099",
    ]);

    $code = Category::generateCode($this->project);

    expect($code)->toBe("{$this->project->code}-cat-100");
});


// SET POSITION
test('first root category position starts at 1', function () {
    $position = Category::setPosition($this->project, 'parent_id', null);

    expect($position)->toBe(1);
});

test('category position increments from the highest position', function () {
    Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
        'position' => 2,
    ]);

    Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
        'position' => 5,
    ]);

    $position = Category::setPosition($this->project, 'parent_id', null);

    expect($position)->toBe(6);
});

test('category positions are independent for each project', function () {
    $projectB = Project::factory()->create();

    Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
        'position' => 2,
    ]);

    Category::factory()->create([
        'project_id' => $projectB->id,
        'parent_id' => null,
        'position' => 10,
    ]);

    expect(Category::setPosition($this->project, 'parent_id', null))
        ->toBe(3);

    expect(Category::setPosition($projectB, 'parent_id', null))
        ->toBe(11);
});

test('child category positions are independent for each parent', function () {
    $parent1 = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
    ]);

    $parent2 = Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => null,
    ]);

    Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => $parent1->id,
        'position' => 3,
    ]);

    Category::factory()->create([
        'project_id' => $this->project->id,
        'parent_id' => $parent2->id,
        'position' => 7,
    ]);

    expect(Category::setPosition($this->project, 'parent_id', $parent1->id))
        ->toBe(4);

    expect(Category::setPosition($this->project, 'parent_id', $parent2->id))
        ->toBe(8);
});
