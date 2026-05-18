<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Wisata;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WisataTest extends TestCase
{
    use RefreshDatabase;

    public function test_wisata_can_be_created()
    {
        $category = Category::factory()->create();
        
        $wisata = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Gunung Bromo',
            'ticket_price' => 50000,
            'distance' => 25.5,
        ]);

        $this->assertDatabaseHas('wisatas', [
            'name' => 'Gunung Bromo',
            'ticket_price' => 50000,
            'distance' => 25.5,
        ]);
    }

    public function test_wisata_belongs_to_category()
    {
        $category = Category::factory()->create();
        $wisata = Wisata::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $wisata->category);
        $this->assertEquals($category->id, $wisata->category->id);
    }

    public function test_wisata_fillable_fields()
    {
        $category = Category::factory()->create();
        $wisata = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Test Wisata',
            'actual_rating' => 4.5,
            'review_count' => 100,
        ]);

        $this->assertEquals('Test Wisata', $wisata->name);
        $this->assertEquals(4.5, $wisata->actual_rating);
        $this->assertEquals(100, $wisata->review_count);
    }

    public function test_wisata_casts()
    {
        $category = Category::factory()->create();
        $wisata = Wisata::factory()->create([
            'category_id' => $category->id,
            'latitude' => 51.5074,
            'longitude' => -0.1278,
            'ticket_price' => 100000.50,
            'actual_rating' => 4.75,
            'review_count' => 50,
        ]);

        // Decimal fields are returned as strings from database
        $this->assertTrue(is_numeric($wisata->latitude));
        $this->assertTrue(is_numeric($wisata->longitude));
        $this->assertIsInt($wisata->review_count);
    }

    public function test_wisata_facilities_cast_to_array()
    {
        $category = Category::factory()->create();
        $wisata = Wisata::factory()->create([
            'category_id' => $category->id,
            'facilities' => ['Parkir', 'Toilet', 'Restoran'],
        ]);

        $this->assertIsArray($wisata->facilities);
        $this->assertContains('Parkir', $wisata->facilities);
    }
}
