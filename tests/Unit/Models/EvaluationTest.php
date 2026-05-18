<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Evaluation;
use App\Models\Wisata;
use App\Models\Criteria;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EvaluationTest extends TestCase
{
    use RefreshDatabase;

    public function test_evaluation_can_be_created()
    {
        $wisata = Wisata::factory()->create();
        $criteria = Criteria::factory()->create();

        $evaluation = Evaluation::factory()->create([
            'wisata_id' => $wisata->id,
            'criteria_id' => $criteria->id,
            'value' => 85.5,
        ]);

        $this->assertDatabaseHas('evaluations', [
            'wisata_id' => $wisata->id,
            'criteria_id' => $criteria->id,
            'value' => 85.5,
        ]);
    }

    public function test_evaluation_belongs_to_wisata()
    {
        $wisata = Wisata::factory()->create();
        $criteria = Criteria::factory()->create();
        $evaluation = Evaluation::factory()->create([
            'wisata_id' => $wisata->id,
            'criteria_id' => $criteria->id,
        ]);

        $this->assertInstanceOf(Wisata::class, $evaluation->wisata);
        $this->assertEquals($wisata->id, $evaluation->wisata->id);
    }

    public function test_evaluation_belongs_to_criteria()
    {
        $wisata = Wisata::factory()->create();
        $criteria = Criteria::factory()->create();
        $evaluation = Evaluation::factory()->create([
            'wisata_id' => $wisata->id,
            'criteria_id' => $criteria->id,
        ]);

        $this->assertInstanceOf(Criteria::class, $evaluation->criteria);
        $this->assertEquals($criteria->id, $evaluation->criteria->id);
    }

    public function test_evaluation_fillable_fields()
    {
        $wisata = Wisata::factory()->create();
        $criteria = Criteria::factory()->create();
        $evaluation = Evaluation::factory()->create([
            'wisata_id' => $wisata->id,
            'criteria_id' => $criteria->id,
            'value' => 75.25,
        ]);

        $this->assertEquals(75.25, $evaluation->value);
    }

    public function test_evaluation_value_decimal_cast()
    {
        $wisata = Wisata::factory()->create();
        $criteria = Criteria::factory()->create();
        $evaluation = Evaluation::factory()->create([
            'wisata_id' => $wisata->id,
            'criteria_id' => $criteria->id,
            'value' => 90.50,
        ]);

        // Decimal cast returns string, check it's numeric
        $this->assertTrue(is_numeric($evaluation->value));
        $this->assertStringContainsString('90', (string)$evaluation->value);
    }

    public function test_multiple_evaluations_for_same_wisata()
    {
        $wisata = Wisata::factory()->create();
        $criteria1 = Criteria::factory()->create();
        $criteria2 = Criteria::factory()->create();

        Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria1->id, 'value' => 80]);
        Evaluation::factory()->create(['wisata_id' => $wisata->id, 'criteria_id' => $criteria2->id, 'value' => 90]);

        $evaluations = Evaluation::where('wisata_id', $wisata->id)->get();

        $this->assertCount(2, $evaluations);
    }
}
