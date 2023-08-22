<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diary>
 */
class DiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "candidate_id" => rand(1, 10),
            "company_id" => rand(1, 10),
            "project_reference" => "RsZLYn9v9v",
            "status" => 1,
            "client_id_fk" => "20230822279557"
        ];
    }
}
