<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projects>
 */
class ProjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => "Developper",
            "company_id" => rand(1, 10),
            "description" => $this->faker->sentence(),
            "job_reference" => Str::random(10),
            "client_id_fk" => "20230822279557"
        ];
    }
}
