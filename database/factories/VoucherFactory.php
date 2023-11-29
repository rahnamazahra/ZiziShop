<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class VoucherFactory extends Factory
{

    public function definition(): array
    {
        return [
            "code"  => strtoupper($this->faker->word),
            "discount_percent" => $this->faker->numberBetween(1,10) * 10,
            "remaining" => $this->faker->numberBetween(0, 100),
        ];
    }
}
