<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Head User',
                'email' => 'head@example.com',
                'password' => Hash::make('password'),
                'role' => 'head',
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'System Analyst User',
                'email' => 'analyst@example.com',
                'password' => Hash::make('password'),
                'role' => 'system analyst',
            ],
            [
                'name' => 'Developer User',
                'email' => 'developer@example.com',
                'password' => Hash::make('password'),
                'role' => 'developer',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                ]
            );

            // $user->assignRole($userData['role']);
        }
    }
}
