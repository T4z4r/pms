<?php

namespace Database\Seeders;

use App\Models\ProjectPriority;
use Illuminate\Database\Seeder;

class ProjectPrioritySeeder extends Seeder
{
    public function run(): void
    {
        ProjectPriority::create(['name' => 'Low', 'level' => 1, 'status' => 'active']);
        ProjectPriority::create(['name' => 'Medium', 'level' => 2, 'status' => 'active']);
        ProjectPriority::create(['name' => 'High', 'level' => 3, 'status' => 'active']);
    }
}
