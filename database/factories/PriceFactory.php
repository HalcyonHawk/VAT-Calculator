<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gross_sum' => $faker->unique()->numberBetween(1, 1000),
            'vat_rate' => $faker->unique()->numberBetween(-1, 1),
        ];
    }
}
