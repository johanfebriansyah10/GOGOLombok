<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Wisata;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\Weight;
use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecommendationControllerTest extends TestCase
{
    use RefreshDatabase;

    private function setupTestData()
    {
        // Create categories
        $category = Category::factory()->create(['name' => 'Alam']);

        // Create wisatas
        $wisata1 = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Gunung Bromo',
            'ticket_price' => 50000,
            'distance' => 10,
            'facilities_count' => 3,
            'actual_rating' => 4.5,
            'review_count' => 100,
            'facilities' => ['Parkir', 'Toilet', 'Restoran'],
        ]);

        $wisata2 = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Pantai Ijen',
            'ticket_price' => 30000,
            'distance' => 5,
            'facilities_count' => 2,
            'actual_rating' => 4.0,
            'review_count' => 50,
            'facilities' => ['Parkir', 'Toilet'],
        ]);

        // Create criterias
        $criteria1 = Criteria::factory()->create(['code' => 'C1', 'name' => 'Harga', 'type' => 'cost']);
        $criteria2 = Criteria::factory()->create(['code' => 'C2', 'name' => 'Jarak', 'type' => 'cost']);
        $criteria3 = Criteria::factory()->create(['code' => 'C3', 'name' => 'Fasilitas', 'type' => 'benefit']);
        $criteria4 = Criteria::factory()->create(['code' => 'C4', 'name' => 'Rating', 'type' => 'benefit']);

        // Create weights
        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria3->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria4->id, 'weight' => 0.25]);

        // Create evaluations
        foreach ([$wisata1, $wisata2] as $wisata) {
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria1->id, 'value' => $wisata->ticket_price]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria2->id, 'value' => $wisata->distance]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria3->id, 'value' => $wisata->facilities_count]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria4->id, 'value' => $wisata->actual_rating]);
        }

        return [
            'wisata1' => $wisata1,
            'wisata2' => $wisata2,
            'category' => $category,
            'criterias' => [$criteria1, $criteria2, $criteria3, $criteria4],
        ];
    }

    public function test_recommendations_index_page_loads()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('saw.recommendations.index');
    }

    public function test_recommendations_index_contains_filter_form()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index'));

        $response->assertStatus(200);
        $response->assertViewHas('categories');
        $response->assertViewHas('criterias');
        $response->assertViewHas('filters');
    }

    public function test_filter_by_budget()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['max_budget' => 40000]));

        $response->assertStatus(200);
        $response->assertViewHas('hasFilters', true);
        $response->assertViewHas('result');
    }

    public function test_filter_by_distance()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['max_distance' => 7]));

        $response->assertStatus(200);
        $response->assertViewHas('hasFilters', true);
    }

    public function test_filter_by_rating()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['min_rating' => 4.0]));

        $response->assertStatus(200);
        $response->assertViewHas('hasFilters', true);
    }

    public function test_filter_by_category()
    {
        $data = $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['category_id' => $data['category']->id]));

        $response->assertStatus(200);
        $response->assertViewHas('hasFilters', true);
    }

    public function test_filter_by_facilities()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['facilities' => ['Parkir', 'Toilet']]));

        $response->assertStatus(200);
        $response->assertViewHas('hasFilters', true);
    }

    public function test_multiple_filters_combined()
    {
        $data = $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', [
            'max_budget' => 60000,
            'max_distance' => 15,
            'min_rating' => 3.0,
            'category_id' => $data['category']->id,
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('hasFilters', true);
    }

    public function test_reset_filters()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.reset'));

        $response->assertRedirect(route('saw.recommendations.index'));
    }

    public function test_empty_filters_shows_no_results()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index'));

        $response->assertStatus(200);
        $response->assertViewHas('hasFilters', false);
        $response->assertViewHas('result', null);
    }

    public function test_categories_are_passed_to_view()
    {
        $data = $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index'));

        $response->assertStatus(200);
        $categories = $response->viewData('categories');
        $this->assertGreaterThan(0, count($categories));
    }

    public function test_criterias_are_passed_to_view()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index'));

        $response->assertStatus(200);
        $criterias = $response->viewData('criterias');
        $this->assertGreaterThan(0, count($criterias));
    }

    public function test_filters_are_passed_to_view_when_provided()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['max_budget' => 50000]));

        $response->assertStatus(200);
        $filters = $response->viewData('filters');
        $this->assertArrayHasKey('max_budget', $filters);
        $this->assertEquals(50000, $filters['max_budget']);
    }

    public function test_result_contains_ranking_data()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['max_budget' => 60000]));

        $response->assertStatus(200);
        
        if ($response->viewData('hasFilters')) {
            $result = $response->viewData('result');
            $this->assertArrayHasKey('ranking', $result);
        }
    }

    public function test_invalid_budget_filter_returns_empty()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.recommendations.index', ['max_budget' => 1000]));

        $response->assertStatus(200);
        $this->assertTrue(
            $response->viewData('hasFilters') === false || 
            count($response->viewData('result')['ranking'] ?? []) === 0
        );
    }
}
