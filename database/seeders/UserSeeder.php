<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@kritissumsel.com'],
            [
                'name' => 'Super Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('super_admin');

        $editor = User::firstOrCreate(
            ['email' => 'editor@kritissumsel.com'],
            [
                'name' => 'Editor Redaksi',
                'username' => 'editor',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $editor->assignRole('editor');

        $author = User::firstOrCreate(
            ['email' => 'penulis@kritissumsel.com'],
            [
                'name' => 'Jurnalis Kritis Sumsel',
                'username' => 'jurnalis',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $author->assignRole('author');
    }
}
