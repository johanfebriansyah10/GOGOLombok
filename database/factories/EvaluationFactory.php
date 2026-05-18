<?php

namespace Database\Factories;

use App\Models\Evaluation;
use App\Models\Wisata;
use App\Models\Criteria;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    protected $model = Evaluation::class;

    public function definition(): array
    {
        return [
            'wisata_id' => Wisata::factory(),
            'criteria_id' => Criteria::factory(),
            'value' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
