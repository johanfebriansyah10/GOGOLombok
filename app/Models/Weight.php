<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Weight extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_id',
        'weight',
    ];

    protected $casts = [
        'weight' => 'decimal:4',
    ];

    /**
     * Get the criteria this weight belongs to
     */
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    /**
     * Get total weight of all weights
     */
    public static function totalWeight()
    {
        return self::sum('weight');
    }

    /**
     * Check if total weight equals 1
     */
    public static function isWeightValid()
    {
        $total = self::totalWeight();
        return $total >= 0.99 && $total <= 1.01; // Allow small floating point differences
    }
}
