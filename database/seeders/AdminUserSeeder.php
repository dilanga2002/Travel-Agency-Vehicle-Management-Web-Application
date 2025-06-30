<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'sritravelowner@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+94 72 372 2421',
        ]);
    }
}