<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@portal.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Default settings row
        Setting::create(['gemini_api_key' => null]);
    }
}
