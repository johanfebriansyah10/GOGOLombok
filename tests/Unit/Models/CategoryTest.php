<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Wisata;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created()
    {
        $category = Category::factory()->create([
            'name' => 'Alam',
            'description' => 'Wisata Alam',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Alam',
            'description' => 'Wisata Alam',
        ]);
    }

    public function test_category_has_many_wisatas()
    {
        $category = Category::factory()
            ->has(Wisata::factory()->count(3))
            ->create();

        $this->assertCount(3, $category->wisatas);
    }

    public function test_category_fillable_fields()
    {
        $category = Category::factory()->create([
            'name' => 'Test Category',
            'description' => 'Test Description',
        ]);

        $this->assertEquals('Test Category', $category->name);
        $this->assertEquals('Test Description', $category->description);
    }
}
