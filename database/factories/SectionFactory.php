<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name'=>$this->faker->unique()->randomElement(['Department of Surgery and Neurology','Department of children','Department of lab','Department of Brain']),
            'description'=>$this->faker->paragraph
        ];
    }
}
