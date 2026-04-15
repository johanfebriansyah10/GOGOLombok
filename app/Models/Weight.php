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
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
    public static function totalWeight()
    {
        return self::sum('weight');
    }
    public static function isWeightValid()
    {
        $total = self::totalWeight();
        return $total >= 0.99 && $total <= 1.01;
    }
}
