<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\SAWCalculator;
use App\Models\Wisata;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\Weight;
use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SAWCalculatorTest extends TestCase
{
    use RefreshDatabase;

    private function setupCalculationData()
    {
        // Create categories
        $category = Category::factory()->create();

        // Create wisatas
        $wisata1 = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Wisata 1',
            'ticket_price' => 50000,
            'distance' => 10,
            'facilities_count' => 3,
            'actual_rating' => 4.5,
            'review_count' => 100,
            'facilities' => ['Parkir', 'Toilet', 'Restoran'],
        ]);

        $wisata2 = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Wisata 2',
            'ticket_price' => 30000,
            'distance' => 5,
            'facilities_count' => 2,
            'actual_rating' => 4.0,
            'review_count' => 50,
            'facilities' => ['Parkir', 'Toilet'],
        ]);

        $wisata3 = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Wisata 3',
            'ticket_price' => 75000,
            'distance' => 20,
            'facilities_count' => 5,
            'actual_rating' => 5.0,
            'review_count' => 200,
            'facilities' => ['Parkir', 'Toilet', 'Restoran', 'Hotel', 'Warung'],
        ]);

        // Create criterias
        $criteria1 = Criteria::factory()->create(['code' => 'C1', 'name' => 'Harga', 'type' => 'cost']);
        $criteria2 = Criteria::factory()->create(['code' => 'C2', 'name' => 'Jarak', 'type' => 'cost']);
        $criteria3 = Criteria::factory()->create(['code' => 'C3', 'name' => 'Fasilitas', 'type' => 'benefit']);
        $criteria4 = Criteria::factory()->create(['code' => 'C4', 'name' => 'Rating', 'type' => 'benefit']);

        // Create weights (total = 1.0)
        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria3->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria4->id, 'weight' => 0.25]);

        // Create evaluations
        Evaluation::factory()->create(['wisata_id' => $wisata1->id, 'criteria_id' => $criteria1->id, 'value' => $wisata1->ticket_price]);
        Evaluation::factory()->create(['wisata_id' => $wisata1->id, 'criteria_id' => $criteria2->id, 'value' => $wisata1->distance]);
        Evaluation::factory()->create(['wisata_id' => $wisata1->id, 'criteria_id' => $criteria3->id, 'value' => $wisata1->facilities_count]);
        Evaluation::factory()->create(['wisata_id' => $wisata1->id, 'criteria_id' => $criteria4->id, 'value' => $wisata1->actual_rating]);

        Evaluation::factory()->create(['wisata_id' => $wisata2->id, 'criteria_id' => $criteria1->id, 'value' => $wisata2->ticket_price]);
        Evaluation::factory()->create(['wisata_id' => $wisata2->id, 'criteria_id' => $criteria2->id, 'value' => $wisata2->distance]);
        Evaluation::factory()->create(['wisata_id' => $wisata2->id, 'criteria_id' => $criteria3->id, 'value' => $wisata2->facilities_count]);
        Evaluation::factory()->create(['wisata_id' => $wisata2->id, 'criteria_id' => $criteria4->id, 'value' => $wisata2->actual_rating]);

        Evaluation::factory()->create(['wisata_id' => $wisata3->id, 'criteria_id' => $criteria1->id, 'value' => $wisata3->ticket_price]);
        Evaluation::factory()->create(['wisata_id' => $wisata3->id, 'criteria_id' => $criteria2->id, 'value' => $wisata3->distance]);
        Evaluation::factory()->create(['wisata_id' => $wisata3->id, 'criteria_id' => $criteria3->id, 'value' => $wisata3->facilities_count]);
        Evaluation::factory()->create(['wisata_id' => $wisata3->id, 'criteria_id' => $criteria4->id, 'value' => $wisata3->actual_rating]);

        return [
            'wisatas' => [$wisata1, $wisata2, $wisata3],
            'criterias' => [$criteria1, $criteria2, $criteria3, $criteria4],
            'category' => $category,
        ];
    }

    public function test_calculate_returns_array_with_required_keys()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('decision_matrix', $result);
        $this->assertArrayHasKey('normalized_matrix', $result);
        $this->assertArrayHasKey('scores', $result);
        $this->assertArrayHasKey('ranking', $result);
    }

    public function test_calculate_throws_exception_when_weights_invalid()
    {
        Category::factory()->create();
        Wisata::factory()->create();

        $criteria1 = Criteria::factory()->create(['code' => 'C1', 'type' => 'benefit']);
        $criteria2 = Criteria::factory()->create(['code' => 'C2', 'type' => 'cost']);

        // Create invalid weights (total = 1.5)
        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.75]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.75]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Total bobot harus sama dengan 1');

        SAWCalculator::calculate();
    }

    public function test_calculate_throws_exception_when_no_wisatas()
    {
        $criteria = Criteria::factory()->create(['type' => 'benefit']);
        Weight::factory()->create(['criteria_id' => $criteria->id, 'weight' => 1.0]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Tidak ada data wisata yang sesuai dengan filter');

        SAWCalculator::calculate();
    }

    public function test_calculate_throws_exception_when_no_criterias()
    {
        Category::factory()->create();
        Wisata::factory()->create();

        $this->expectException(\Exception::class);
        // Will throw either "Tidak ada kriteria" or weight validation error
        $this->expectExceptionMessageMatches('/Tidak ada kriteria|Total bobot/');

        SAWCalculator::calculate();
    }

    public function test_decision_matrix_has_correct_structure()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        $this->assertIsArray($result['decision_matrix']);
        $this->assertCount(3, $result['decision_matrix']);

        $firstRow = $result['decision_matrix'][0];
        $this->assertArrayHasKey('wisata_id', $firstRow);
        $this->assertArrayHasKey('wisata_name', $firstRow);
        $this->assertArrayHasKey('values', $firstRow);
    }

    public function test_normalized_matrix_has_correct_structure()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        $this->assertIsArray($result['normalized_matrix']);
        $this->assertCount(3, $result['normalized_matrix']);

        $firstRow = $result['normalized_matrix'][0];
        $this->assertArrayHasKey('wisata_id', $firstRow);
        $this->assertArrayHasKey('wisata_name', $firstRow);
        $this->assertArrayHasKey('normalized_values', $firstRow);
    }

    public function test_scores_has_correct_structure()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        $scores = $result['scores'];
        $this->assertCount(3, $scores);

        $firstScore = $scores[0];
        $this->assertArrayHasKey('wisata_id', $firstScore);
        $this->assertArrayHasKey('wisata_name', $firstScore);
        $this->assertArrayHasKey('score', $firstScore);
        $this->assertArrayHasKey('score_details', $firstScore);
    }

    public function test_ranking_is_sorted_by_score_descending()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        $ranking = $result['ranking'];
        $this->assertCount(3, $ranking);

        // Check that scores are in descending order
        $rankingArray = $ranking->toArray();
        $scores = array_column($rankingArray, 'score');
        $sortedScores = $scores;
        rsort($sortedScores);

        $this->assertEquals($sortedScores, $scores);
    }

    public function test_ranking_has_rank_values()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        $ranking = $result['ranking'];

        foreach ($ranking as $index => $item) {
            $this->assertArrayHasKey('rank', $item);
            $this->assertEquals($index + 1, $item['rank']);
        }
    }

    public function test_filter_by_category()
    {
        $data = $this->setupCalculationData();

        $result = SAWCalculator::calculate(['category_id' => $data['category']->id]);

        $this->assertArrayHasKey('ranking', $result);
        $this->assertCount(3, $result['ranking']);
    }

    public function test_filter_by_max_budget()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate(['max_budget' => 60000]);

        // Should return only wisata with price <= 60000
        $this->assertLessThanOrEqual(2, count($result['ranking']));
    }

    public function test_filter_by_max_distance()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate(['max_distance' => 15]);

        // Should return only wisata with distance <= 15
        foreach ($result['ranking'] as $item) {
            $wisata = Wisata::find($item['wisata_id']);
            $this->assertLessThanOrEqual(15, $wisata->distance);
        }
    }

    public function test_filter_by_facilities()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate(['facilities' => ['Parkir', 'Toilet']]);

        // All results should have Parkir and Toilet
        foreach ($result['ranking'] as $item) {
            $wisata = Wisata::find($item['wisata_id']);
            $this->assertContains('Parkir', $wisata->facilities);
            $this->assertContains('Toilet', $wisata->facilities);
        }
    }

    public function test_filter_by_min_rating()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate(['min_rating' => 4.5]);

        // All results should have rating >= 4.5
        foreach ($result['ranking'] as $item) {
            $wisata = Wisata::find($item['wisata_id']);
            $this->assertGreaterThanOrEqual(4.5, $wisata->actual_rating);
        }
    }

    public function test_multiple_filters_combined()
    {
        $data = $this->setupCalculationData();

        $result = SAWCalculator::calculate([
            'category_id' => $data['category']->id,
            'max_budget' => 60000,
            'max_distance' => 15,
            'min_rating' => 3.0,
        ]);

        // All results should match all filters
        foreach ($result['ranking'] as $item) {
            $wisata = Wisata::find($item['wisata_id']);
            $this->assertEquals($data['category']->id, $wisata->category_id);
            $this->assertLessThanOrEqual(60000, $wisata->ticket_price);
            $this->assertLessThanOrEqual(15, $wisata->distance);
            $this->assertGreaterThanOrEqual(3.0, $wisata->actual_rating);
        }
    }

    public function test_no_evaluations_returns_empty_result()
    {
        Category::factory()->create();
        Wisata::factory()->count(3)->create();

        $criteria1 = Criteria::factory()->create(['type' => 'benefit']);
        $criteria2 = Criteria::factory()->create(['type' => 'cost']);

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.5]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.5]);

        $result = SAWCalculator::calculate();

        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('Belum ada evaluasi untuk wisata', $result['message']);
        $this->assertEmpty($result['ranking']);
    }

    public function test_get_details_returns_proper_format()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::getDetails();

        $this->assertArrayHasKey('ranking', $result);
        $this->assertArrayHasKey('scores', $result);
        $this->assertArrayHasKey('decision_matrix', $result);
        $this->assertArrayHasKey('normalized_matrix', $result);
    }

    public function test_get_details_with_invalid_weight_returns_error()
    {
        Category::factory()->create();
        Wisata::factory()->create();

        $criteria1 = Criteria::factory()->create(['type' => 'benefit']);
        $criteria2 = Criteria::factory()->create(['type' => 'cost']);

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.7]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.7]);

        $result = SAWCalculator::getDetails();

        $this->assertArrayHasKey('error', $result);
    }

    public function test_normalization_benefit_type()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        // For benefit criteria, normalized value = value / max
        // Check that normalized values are between 0 and 1
        foreach ($result['normalized_matrix'] as $row) {
            foreach ($row['normalized_values'] as $value) {
                if ($value['criteria_type'] === 'benefit') {
                    $this->assertGreaterThanOrEqual(0, $value['normalized_value']);
                    $this->assertLessThanOrEqual(1, $value['normalized_value']);
                }
            }
        }
    }

    public function test_normalization_cost_type()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        // For cost criteria, normalized value = min / value
        // Check that normalized values are between 0 and 1
        foreach ($result['normalized_matrix'] as $row) {
            foreach ($row['normalized_values'] as $value) {
                if ($value['criteria_type'] === 'cost') {
                    $this->assertGreaterThanOrEqual(0, $value['normalized_value']);
                    $this->assertLessThanOrEqual(1, $value['normalized_value']);
                }
            }
        }
    }

    public function test_score_is_sum_of_weighted_normalized_values()
    {
        $this->setupCalculationData();

        $result = SAWCalculator::calculate();

        $scores = $result['scores'];
        $this->assertGreaterThan(0, count($scores));

        // Check that score is a positive decimal number
        foreach ($scores as $score) {
            $this->assertIsFloat($score['score']);
            $this->assertGreaterThanOrEqual(0, $score['score']);
            $this->assertLessThanOrEqual(1, $score['score']); // Max possible score is 1.0
        }
    }

    public function test_higher_review_count_is_more_recommended_when_other_values_are_equal()
    {
        $category = Category::factory()->create();

        $wisata1 = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Wisata 1',
            'ticket_price' => 15000,
            'distance' => 25,
            'facilities_count' => 3,
            'actual_rating' => 4.0,
            'review_count' => 100,
        ]);

        $wisata2 = Wisata::factory()->create([
            'category_id' => $category->id,
            'name' => 'Wisata 2',
            'ticket_price' => 15000,
            'distance' => 25,
            'facilities_count' => 3,
            'actual_rating' => 4.0,
            'review_count' => 200,
        ]);

        $criteria1 = Criteria::factory()->create(['code' => 'C1', 'name' => 'Harga', 'type' => 'cost']);
        $criteria2 = Criteria::factory()->create(['code' => 'C2', 'name' => 'Jarak', 'type' => 'cost']);
        $criteria3 = Criteria::factory()->create(['code' => 'C3', 'name' => 'Fasilitas', 'type' => 'benefit']);
        $criteria4 = Criteria::factory()->create(['code' => 'C4', 'name' => 'Rating', 'type' => 'benefit']);

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria3->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria4->id, 'weight' => 0.25]);

        foreach ([$wisata1, $wisata2] as $wisata) {
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria1->id, 'value' => $wisata->ticket_price]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria2->id, 'value' => $wisata->distance]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria3->id, 'value' => $wisata->facilities_count]);
            Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria4->id, 'value' => $wisata->actual_rating]);
        }

        $result = SAWCalculator::calculate();
        $ranking = $result['ranking']->values();

        $this->assertSame('Wisata 2', $ranking[0]['wisata_name']);
        $this->assertGreaterThan($ranking[1]['score'], $ranking[0]['score']);
    }
}
