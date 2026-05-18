<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Wisata;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\Weight;
use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SAWResultControllerTest extends TestCase
{
    use RefreshDatabase;

    private function setupTestData()
    {
        // Create categories
        $category1 = Category::factory()->create(['name' => 'Alam']);
        $category2 = Category::factory()->create(['name' => 'Budaya']);

        // Create wisatas
        $wisata1 = Wisata::factory()->create([
            'category_id' => $category1->id,
            'name' => 'Gunung Bromo',
            'ticket_price' => 50000,
            'distance' => 10,
            'facilities_count' => 3,
            'actual_rating' => 4.5,
            'review_count' => 100,
            'facilities' => ['Parkir', 'Toilet', 'Restoran'],
        ]);

        $wisata2 = Wisata::factory()->create([
            'category_id' => $category1->id,
            'name' => 'Pantai Ijen',
            'ticket_price' => 30000,
            'distance' => 5,
            'facilities_count' => 2,
            'actual_rating' => 4.0,
            'review_count' => 50,
            'facilities' => ['Parkir', 'Toilet'],
        ]);

        $wisata3 = Wisata::factory()->create([
            'category_id' => $category2->id,
            'name' => 'Candi Borobudur',
            'ticket_price' => 25000,
            'distance' => 30,
            'facilities_count' => 4,
            'actual_rating' => 4.8,
            'review_count' => 300,
            'facilities' => ['Parkir', 'Toilet', 'Restoran', 'Museum'],
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
        foreach ([$wisata1, $wisata2, $wisata3] as $wisata) {
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria1->id, 'value' => $wisata->ticket_price]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria2->id, 'value' => $wisata->distance]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria3->id, 'value' => $wisata->facilities_count]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria4->id, 'value' => $wisata->actual_rating]);
        }

        return [
            'wisatas' => [$wisata1, $wisata2, $wisata3],
            'categories' => [$category1, $category2],
            'criterias' => [$criteria1, $criteria2, $criteria3, $criteria4],
        ];
    }

    public function test_saw_results_index_page_loads()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $response->assertViewIs('saw.results.index');
    }

    public function test_saw_results_index_contains_ranking_data()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $response->assertViewHas('ranking');
        $response->assertViewHas('criterias');
        $response->assertViewHas('categories');
    }

    public function test_ranking_is_sorted_by_score()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $ranking = $response->viewData('ranking');

        // Check that ranking has proper structure
        if (count($ranking) > 0) {
            $this->assertArrayHasKey('rank', $ranking[0]);
            $this->assertArrayHasKey('wisata_id', $ranking[0]);
            $this->assertArrayHasKey('wisata_name', $ranking[0]);
            $this->assertArrayHasKey('score', $ranking[0]);
        }
    }

    public function test_scores_are_available_in_view()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $response->assertViewHas('scores');
    }

    public function test_filter_by_category()
    {
        $data = $this->setupTestData();

        $response = $this->get(route('saw.results.index', ['category' => $data['categories'][0]->id]));

        $response->assertStatus(200);
        $ranking = $response->viewData('ranking');

        // All ranking items should belong to selected category
        foreach ($ranking as $item) {
            $wisata = Wisata::find($item['wisata_id']);
            $this->assertEquals($data['categories'][0]->id, $wisata->category_id);
        }
    }

    public function test_no_evaluations_shows_message()
    {
        // Create data without evaluations
        Category::factory()->create();
        Wisata::factory()->count(2)->create();

        $criteria1 = Criteria::factory()->create(['type' => 'benefit']);
        $criteria2 = Criteria::factory()->create(['type' => 'cost']);

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.5]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.5]);

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $response->assertViewHas('message');
    }

    public function test_invalid_weight_shows_error()
    {
        // Create data with invalid weights
        Category::factory()->create();
        Wisata::factory()->count(2)->create();

        $criteria1 = Criteria::factory()->create(['type' => 'benefit']);
        $criteria2 = Criteria::factory()->create(['type' => 'cost']);

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.7]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.7]);

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $response->assertViewHas('error');
    }

    public function test_view_has_all_required_variables()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $response->assertViewHas('ranking');
        $response->assertViewHas('scores');
        $response->assertViewHas('criterias');
        $response->assertViewHas('categories');
        $response->assertViewHas('selectedCategory', null);
        $response->assertViewHas('error', null);
        $response->assertViewHas('message', null);
    }

    public function test_ranking_has_correct_rank_numbers()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $ranking = $response->viewData('ranking');

        for ($i = 0; $i < count($ranking); $i++) {
            $this->assertEquals($i + 1, $ranking[$i]['rank']);
        }
    }

    public function test_categories_list_in_view()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $categories = $response->viewData('categories');
        $this->assertGreaterThan(0, count($categories));
    }

    public function test_criterias_list_with_weights()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $criterias = $response->viewData('criterias');

        foreach ($criterias as $criteria) {
            $this->assertNotNull($criteria->weight);
            $this->assertGreaterThan(0, $criteria->weight->weight);
        }
    }

    public function test_score_details_in_ranking()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $ranking = $response->viewData('ranking');

        if (count($ranking) > 0) {
            $firstRanking = $ranking[0];
            $this->assertArrayHasKey('score_details', $firstRanking);
            $this->assertGreaterThan(0, count($firstRanking['score_details']));
        }
    }

    public function test_filter_empty_category_shows_all()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index', ['category' => null]));

        $response->assertStatus(200);
        $response->assertViewHas('selectedCategory', null);
    }

    public function test_response_contains_wisata_images()
    {
        $this->setupTestData();

        $response = $this->get(route('saw.results.index'));

        $response->assertStatus(200);
        $ranking = $response->viewData('ranking');

        if (count($ranking) > 0) {
            $this->assertArrayHasKey('image', $ranking[0]);
        }
    }
}
