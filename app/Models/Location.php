<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'is_popular'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_popular' => 'boolean'
    ];

    /**
     * Get the villas for the location.
     */
    public function villas(): HasMany
    {
        return $this->hasMany(Villa::class);
    }

    /**
     * Get the active villas for the location.
     */
    public function activeVillas(): HasMany
    {
        return $this->hasMany(Villa::class)->where('is_active', true);
    }

    /**
     * Scope a query to only include popular locations.
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getVillaCountAttribute()
    {
        return $this->villas()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
