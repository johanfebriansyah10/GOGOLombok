<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'wisata_id',
        'criteria_id',
        'value',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    /**
     * Get the wisata this evaluation belongs to
     */
    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }

    /**
     * Get the criteria this evaluation relates to
     */
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
