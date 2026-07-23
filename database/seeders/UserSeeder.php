<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'fabien.lecouve@econocom.com',
                'firstname' => 'Fabien',
                'lastname' => 'LECOUVE',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_knowledge_manager' => true
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'password' => $user['password'],
                    'is_admin' => $user['is_admin'],
                    'is_knowledge_manager' => $user['is_knowledge_manager']
                ]
            );
        }
    }
}
