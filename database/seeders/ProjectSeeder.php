<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'code' => 'urgo',
                'label' => 'urgo',
                'phone' => '+33380442655',
                'email' => 'support@urgo.com'
            ]
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(
                ['code' => $project['code']],
                [
                    'label' => $project['label'],
                    'phone' => $project['phone'],
                    'email' => $project['email']
                ]
            );
        }
    }
}
