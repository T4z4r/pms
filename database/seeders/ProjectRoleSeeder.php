<?php

namespace Database\Seeders;

use App\Models\ProjectRole;
use Illuminate\Database\Seeder;

class ProjectRoleSeeder extends Seeder
{
    public function run(): void
    {
        ProjectRole::create(['name' => 'Developer', 'description' => 'Code development', 'status' => 'active']);
        ProjectRole::create(['name' => 'Manager', 'description' => 'Project oversight', 'status' => 'active']);
    }
}
