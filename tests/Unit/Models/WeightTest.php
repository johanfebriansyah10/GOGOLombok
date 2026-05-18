<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Weight;
use App\Models\Criteria;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeightTest extends TestCase
{
    use RefreshDatabase;

    public function test_weight_can_be_created()
    {
        $criteria = Criteria::factory()->create();
        $weight = Weight::factory()->create([
            'criteria_id' => $criteria->id,
            'weight' => 0.25,
        ]);

        $this->assertDatabaseHas('weights', [
            'criteria_id' => $criteria->id,
            'weight' => 0.25,
        ]);
    }

    public function test_weight_belongs_to_criteria()
    {
        $criteria = Criteria::factory()->create();
        $weight = Weight::factory()->create(['criteria_id' => $criteria->id]);

        $this->assertInstanceOf(Criteria::class, $weight->criteria);
        $this->assertEquals($criteria->id, $weight->criteria->id);
    }

    public function test_total_weight_calculation()
    {
        $criteria1 = Criteria::factory()->create();
        $criteria2 = Criteria::factory()->create();
        $criteria3 = Criteria::factory()->create();
        $criteria4 = Criteria::factory()->create();

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria3->id, 'weight' => 0.25]);
        Weight::factory()->create(['criteria_id' => $criteria4->id, 'weight' => 0.25]);

        $totalWeight = Weight::totalWeight();

        $this->assertEquals(1.0, $totalWeight);
    }

    public function test_is_weight_valid_returns_true_when_total_is_one()
    {
        $criteria1 = Criteria::factory()->create();
        $criteria2 = Criteria::factory()->create();

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.5]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.5]);

        $this->assertTrue(Weight::isWeightValid());
    }

    public function test_is_weight_valid_with_tolerance()
    {
        $criteria1 = Criteria::factory()->create();
        $criteria2 = Criteria::factory()->create();

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.51]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.50]);

        // Total = 1.01, should still be valid (within 0.99-1.01 tolerance)
        $this->assertTrue(Weight::isWeightValid());
    }

    public function test_is_weight_invalid_when_total_exceeds_tolerance()
    {
        $criteria1 = Criteria::factory()->create();
        $criteria2 = Criteria::factory()->create();

        Weight::factory()->create(['criteria_id' => $criteria1->id, 'weight' => 0.6]);
        Weight::factory()->create(['criteria_id' => $criteria2->id, 'weight' => 0.5]);

        // Total = 1.1, should be invalid
        $this->assertFalse(Weight::isWeightValid());
    }

    public function test_weight_fillable_fields()
    {
        $criteria = Criteria::factory()->create();
        $weight = Weight::factory()->create([
            'criteria_id' => $criteria->id,
            'weight' => 0.33,
        ]);

        $this->assertEquals(0.33, $weight->weight);
    }

    public function test_weight_decimal_cast()
    {
        $criteria = Criteria::factory()->create();
        $weight = Weight::factory()->create([
            'criteria_id' => $criteria->id,
            'weight' => 0.2500,
        ]);

        // Decimal cast returns string, check it's numeric
        $this->assertTrue(is_numeric($weight->weight));
        $this->assertStringContainsString('0.25', (string)$weight->weight);
    }
}
