<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Wisata extends Model
{
    use HasFactory;

    protected $table = 'wisatas';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'location',
        'address',
        'latitude',
        'longitude',
        'rating',
        'image',
        'ticket_price',
        'distance',
        'facilities_count',
        'actual_rating',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'ticket_price' => 'decimal:2',
        'distance' => 'decimal:2',
        'actual_rating' => 'decimal:2',
    ];

    /**
     * Get the category that owns this wisata
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get evaluations for this wisata
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Resolve a safe public URL for the stored image path.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        $path = trim($this->image);

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, ['/storage/', 'storage/'])) {
            return asset(ltrim($path, '/'));
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        $filename = basename($path);
        foreach (['wisata/' . $filename, 'wisatas/' . $filename] as $candidatePath) {
            if (Storage::disk('public')->exists($candidatePath)) {
                return Storage::url($candidatePath);
            }
        }

        return Storage::url($path);
    }
}
