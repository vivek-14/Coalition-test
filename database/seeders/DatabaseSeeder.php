<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Priorities;
use App\Models\Project;
use App\Models\Tasks;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        Project::factory(2)->create();

        Priorities::factory()->count(4)->sequence(['name' => 'Very High'], ['name' => 'High'], ['name' => 'Medium'], ['name' => 'Low'])->create();

        Tasks::factory(2)->create(['project_id' => 1, 'priority_id' => 1]);
        Tasks::factory(2)->create(['project_id' => 1, 'priority_id' => 2]);
        Tasks::factory(2)->create(['project_id' => 1, 'priority_id' => 3]);
        Tasks::factory(2)->create(['project_id' => 2, 'priority_id' => 1]);
        Tasks::factory(2)->create(['project_id' => 2, 'priority_id' => 2]);

        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}