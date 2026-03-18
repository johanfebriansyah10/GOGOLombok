<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Wisata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WisataTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test category can be retrieved
     */
    public function test_category_can_be_created_and_retrieved(): void
    {
        $category = Category::create([
            'name' => 'Pantai',
            'description' => 'Tempat wisata pantai'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Pantai',
            'description' => 'Tempat wisata pantai'
        ]);

        $retrieved = Category::find($category->id);
        $this->assertEquals('Pantai', $retrieved->name);
    }

    /**
     * Test wisata can be created and belongs to category
     */
    public function test_wisata_belongs_to_category(): void
    {
        $category = Category::create([
            'name' => 'Pantai',
            'description' => 'Tempat wisata pantai'
        ]);

        $wisata = Wisata::create([
            'category_id' => $category->id,
            'name' => 'Pantai Kuta',
            'description' => 'Pantai dengan ombak indah',
            'location' => 'Bali',
            'latitude' => -8.7211,
            'longitude' => 115.1692,
            'rating' => 5
        ]);

        $this->assertDatabaseHas('wisatas', [
            'name' => 'Pantai Kuta',
            'category_id' => $category->id
        ]);

        // Test relationship
        $retrieved = Wisata::find($wisata->id);
        $this->assertEquals($category->id, $retrieved->category->id);
        $this->assertEquals('Pantai', $retrieved->category->name);
    }

    /**
     * Test category has many wisatas
     */
    public function test_category_has_many_wisatas(): void
    {
        $category = Category::create([
            'name' => 'Pantai',
            'description' => 'Tempat wisata pantai'
        ]);

        Wisata::create([
            'category_id' => $category->id,
            'name' => 'Pantai Kuta',
            'location' => 'Bali',
            'rating' => 5
        ]);

        Wisata::create([
            'category_id' => $category->id,
            'name' => 'Pantai Seminyak',
            'location' => 'Bali',
            'rating' => 4
        ]);

        $retrieved = Category::find($category->id);
        $this->assertCount(2, $retrieved->wisatas);
        $this->assertTrue($retrieved->wisatas->contains('name', 'Pantai Kuta'));
        $this->assertTrue($retrieved->wisatas->contains('name', 'Pantai Seminyak'));
    }

    /**
     * Test cascade delete when category is deleted
     */
    public function test_wisatas_deleted_when_category_deleted(): void
    {
        $category = Category::create([
            'name' => 'Pantai',
            'description' => 'Tempat wisata pantai'
        ]);

        $wisata = Wisata::create([
            'category_id' => $category->id,
            'name' => 'Pantai Kuta',
            'location' => 'Bali',
            'rating' => 5
        ]);

        $wisataId = $wisata->id;
        $categoryId = $category->id;

        $category->delete();

        $this->assertDatabaseMissing('categories', ['id' => $categoryId]);
        $this->assertDatabaseMissing('wisatas', ['id' => $wisataId]);
    }

    /**
     * Test seeded data
     */
    public function test_seeded_data_exists(): void
    {
        // Run seeder
        $this->seed(\Database\Seeders\CategorySeeder::class);

        $this->assertDatabaseCount('categories', 4);
        $this->assertDatabaseCount('wisatas', 5);

        $pantaiCategory = Category::where('name', 'Pantai')->first();
        $this->assertNotNull($pantaiCategory);
        $this->assertCount(2, $pantaiCategory->wisatas);
    }
}
