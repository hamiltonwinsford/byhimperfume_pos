<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fragrance>
 */
class FragranceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->name,
            'total_weight' => $this->faker->randomDouble(2, 1, 100),
            'gram_to_ml' => $this->faker->randomDouble(2, 1, 100),
            'ml_to_gram'=> $this->faker->randomDouble(2, 1, 100),
            'gram' => $this->faker->randomDouble(2, 1, 100),
            'mililiter' => $this->faker->randomDouble(2, 1, 100),
            'pump_weight' => $this->faker->randomDouble(2, 1, 100),
            'bottle_weight' => $this->faker->randomDouble(2, 1, 100),
            'product_id'=> $this->faker->numberBetween(121),
        ];
    }
}
