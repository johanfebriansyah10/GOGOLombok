<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Criteria;
use App\Models\Weight;
use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function test_criteria_can_be_created()
    {
        $criteria = Criteria::factory()->create([
            'code' => 'C1',
            'name' => 'Harga Tiket',
            'type' => 'cost',
        ]);

        $this->assertDatabaseHas('criterias', [
            'code' => 'C1',
            'name' => 'Harga Tiket',
            'type' => 'cost',
        ]);
    }

    public function test_criteria_has_one_weight()
    {
        $criteria = Criteria::factory()->create();
        Weight::factory()->create(['criteria_id' => $criteria->id, 'weight' => 0.25]);

        $this->assertInstanceOf(Weight::class, $criteria->weight);
    }

    public function test_criteria_has_many_evaluations()
    {
        $criteria = Criteria::factory()->create();
        Evaluation::factory()->count(5)->create(['criteria_id' => $criteria->id]);

        $this->assertCount(5, $criteria->evaluations);
    }

    public function test_criteria_fillable_fields()
    {
        $criteria = Criteria::factory()->create([
            'code' => 'C1',
            'name' => 'Harga',
            'description' => 'Harga tiket masuk',
            'type' => 'cost',
        ]);

        $this->assertEquals('C1', $criteria->code);
        $this->assertEquals('Harga', $criteria->name);
        $this->assertEquals('cost', $criteria->type);
    }

    public function test_criteria_type_cast()
    {
        $criteria = Criteria::factory()->create(['type' => 'benefit']);

        $this->assertIsString($criteria->type);
        $this->assertEquals('benefit', $criteria->type);
    }

    public function test_criteria_with_benefit_type()
    {
        $criteria = Criteria::factory()->create(['type' => 'benefit']);

        $this->assertTrue($criteria->type === 'benefit');
    }
}
