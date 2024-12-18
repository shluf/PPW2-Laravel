<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'level' => 'admin',
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'level' => 'user',
        ]);

        User::create([
            'name' => 'Reviewer',
            'email' => 'reviewer@reviewer.com',
            'password' => Hash::make('password'),
            'level' => 'internal_reviewer',
        ]);

        User::create([
            'name' => 'fufufafa',
            'email' => 'reviewer2@reviewer.com',
            'password' => Hash::make('password'),
            'level' => 'internal_reviewer',
        ]);
    }
}

