<?php

namespace Database\Factories;

use App\Models\Priorities;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tasks>
 */
class TasksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'priority_id' => Priorities::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph()
        ];
    }
}