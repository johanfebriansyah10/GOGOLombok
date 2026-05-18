<?php

namespace Database\Factories;

use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class WisataFactory extends Factory
{
    protected $model = Wisata::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'image' => $this->faker->imageUrl(),
            'ticket_price' => $this->faker->randomFloat(2, 10000, 100000),
            'distance' => $this->faker->randomFloat(2, 1, 100),
            'facilities_count' => $this->faker->numberBetween(1, 10),
            'actual_rating' => $this->faker->randomFloat(2, 1, 5),
            'review_count' => $this->faker->numberBetween(0, 1000),
            'facilities' => $this->faker->words(5),
        ];
    }
}
