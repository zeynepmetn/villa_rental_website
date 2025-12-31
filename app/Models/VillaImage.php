<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class VillaImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'path',
        'is_primary',
        'order'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer'
    ];

    protected $appends = ['url'];

    /**
     * Get the villa that owns the image.
     */
    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class);
    }

    /**
     * Scope a query to only include primary images.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Get the URL for the image.
     */
    public function getUrlAttribute()
    {
        if (!$this->path) {
            return asset('images/villa-placeholder.jpg');
        }
        
        if (str_starts_with($this->path, 'villa-images/')) {
            if (Storage::disk('public')->exists($this->path)) {
                return asset('storage/' . $this->path);
            }
            return asset('images/villa-placeholder.jpg');
        }
        
        return asset($this->path);
    }

    /**
     * Delete the image file when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            if (str_starts_with($image->path, 'villa-images/')) {
                Storage::disk('public')->delete($image->path);
            }
        });

        // Removed the automatic primary image setting to avoid conflicts with controller logic
    }
}
