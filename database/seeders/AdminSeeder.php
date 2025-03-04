<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin exists before creating
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'student_id' => null,
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'course' => null,
                'email_verified_at' => now(),
            ]);
        }
    }
} 