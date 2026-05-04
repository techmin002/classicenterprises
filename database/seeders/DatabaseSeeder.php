<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call Permission Seeder
        $this->call([
            PermissionSeeder::class,
        ]);

        // Create Super Admin User
        // \App\Models\User::factory()->create([
        //     'name' => 'Super Admin',
        //     'email' => 'super@super.com',
        //     'access_type' => 'super_admin',
        //     'password' => Hash::make('P@ssword002'),
        // ]);
    }
}