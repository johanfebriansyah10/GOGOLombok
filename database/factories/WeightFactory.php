<?php

namespace Database\Factories;

use App\Models\Weight;
use App\Models\Criteria;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightFactory extends Factory
{
    protected $model = Weight::class;

    public function definition(): array
    {
        return [
            'criteria_id' => Criteria::factory(),
            'weight' => $this->faker->randomFloat(2, 0.1, 0.5),
        ];
    }
}
