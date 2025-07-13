<?php

namespace Database\Seeders;

use App\Models\ProjectTag;
use Illuminate\Database\Seeder;

class ProjectTagSeeder extends Seeder
{
    public function run(): void
    {
        ProjectTag::create(['name' => 'Urgent', 'status' => 'active']);
        ProjectTag::create(['name' => 'Backend', 'status' => 'active']);
    }
}
