<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\ProjectTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            BrandSettingsSeeder::class,
            ProjectTypeSeeder::class,
            ProjectPrioritySeeder::class,
            ProjectTagSeeder::class,


        ]);

        
    }
}
