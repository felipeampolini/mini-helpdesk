<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Manager
        User::create([
            'name' => 'Manager',
            'email' => 'manager@email.com',
            'password' => Hash::make('123123123'),
            'role' => 'manager',
        ]);

        // Users
        $users = [
            ['name' => 'Felipe', 'email' => 'felipe@email.com'],
            ['name' => 'Ana', 'email' => 'ana@email.com'],
            ['name' => 'Carlos', 'email' => 'carlos@email.com'],
            ['name' => 'Beatriz', 'email' => 'beatriz@email.com'],
            ['name' => 'Eduardo', 'email' => 'eduardo@email.com'],
            ['name' => 'Mariana', 'email' => 'mariana@email.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('123123123'),
                'role' => 'user',
            ]);
        }
    }
}
