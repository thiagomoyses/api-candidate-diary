<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidates>
 */
class CandidatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->tollFreePhoneNumber,
            'email' => $this->faker->unique()->email,
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'surname' => $this->faker->lastName(),
            'situation' => 1,
            'client_id_fk' => '20230822279557'
        ];
    }
}
