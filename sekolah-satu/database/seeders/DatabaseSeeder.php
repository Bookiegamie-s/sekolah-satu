<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            SubjectSeeder::class,
            ClassSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
        ]);
    }
}
