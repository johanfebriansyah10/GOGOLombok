<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    /**
     * Get the weight for this criteria
     */
    public function weight()
    {
        return $this->hasOne(Weight::class);
    }

    /**
     * Get evaluations for this criteria
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
