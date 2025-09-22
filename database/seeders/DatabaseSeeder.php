<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Material;
use App\Models\Project;
use App\Models\User;
use App\Models\Vendor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
        ]);

        Project::create([
            'user_id' => 1,
            'name' => 'Project 1',
        ]);

        Category::create([
            'project_id' => 1,
            'name' => 'Contractor',
        ]);

        Vendor::create([
            'project_id' => 1,
            'name' => 'Rod',
        ]);

        Material::create([
            'project_id' => 1,
            'vendor_id' => 1,
            'name' => 'Rod',
            'unit' => 'Ton',
            'rate' => 80000,
        ]);
    }
}
