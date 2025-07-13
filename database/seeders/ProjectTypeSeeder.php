<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    public function run(): void
    {
        ProjectType::create(['name' => 'Web Development', 'description' => 'Website projects', 'status' => 'active']);
        ProjectType::create(['name' => 'Mobile App', 'description' => 'Mobile application projects', 'status' => 'active']);
    }
}
