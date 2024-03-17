<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'squad' => $this->faker->randomElement(['squad1', 'squad2', 'squad3', 'squad4', 'squad5', 'NA']),
            'start_date' => $this->faker->date(),
            'notes' => $this->faker->sentence,
        ];
    }
}
