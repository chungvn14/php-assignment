<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo admin nếu chưa có
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Tạo user thường nếu chưa có
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
