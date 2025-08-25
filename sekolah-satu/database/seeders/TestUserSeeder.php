<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User tanpa role untuk testing
        $userNoRole = User::create([
            'name' => 'Test User No Role',
            'email' => 'norole@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Test user without role created: ' . $userNoRole->email);
    }
}
