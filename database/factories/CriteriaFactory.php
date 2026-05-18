<?php

namespace Database\Factories;

use App\Models\Criteria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CriteriaFactory extends Factory
{
    protected $model = Criteria::class;

    public function definition(): array
    {
        static $criteriaCount = 0;
        $criteriaCount++;

        return [
            'code' => 'C' . $criteriaCount,
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['benefit', 'cost']),
        ];
    }
}
