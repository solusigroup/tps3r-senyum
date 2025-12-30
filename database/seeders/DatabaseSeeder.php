<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin Superuser
        User::updateOrCreate(
            ['email' => 'admin@tps3r.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@tps3r.id',
                'password' => bcrypt('admin123'),
                'role' => 'superuser',
                'is_active' => true,
            ]
        );

        // Create Test User
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'administrasi',
                'is_active' => true,
            ]
        );
    }
}
