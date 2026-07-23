<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'code' => 'reader',
                'label' => 'lecteur',
            ],
            [
                'code' => 'technician',
                'label' => 'technicien',
            ],
            [
                'code' => 'technician_referent',
                'label' => 'référent',
            ],
            [
                'code' => 'technical_coordinator',
                'label' => 'coordinateur technique',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['code' => $role['code']],
                ['label' => $role['label']]
            );
        }
    }
}
