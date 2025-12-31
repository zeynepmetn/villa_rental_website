<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Villa extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location_id',
        'realtor_id',
        'bedrooms',
        'bathrooms',
        'capacity',
        'max_guests',
        'size',
        'area',
        'price_per_night',
        'cleaning_fee',
        'is_active',
        'is_featured',
        'check_in_time',
        'check_out_time',
        'min_stay',
        'address',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price_per_night' => 'decimal:2',
        'cleaning_fee' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the realtor (owner) of the villa.
     */
    public function realtor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'realtor_id');
    }

    /**
     * Get the location of the villa.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the images for the villa.
     */
    public function images(): HasMany
    {
        return $this->hasMany(VillaImage::class)->orderBy('order');
    }

    /**
     * Get the primary image for the villa.
     */
    public function primaryImage()
    {
        return $this->hasOne(VillaImage::class)
            ->where('is_primary', true)
            ->withDefault([
                'path' => 'images/villa-placeholder.jpg',
                'url' => asset('images/villa-placeholder.jpg')
            ]);
    }

    /**
     * Get the cached primary image URL.
     */
    public function getPrimaryImageUrlAttribute()
    {
        return \Cache::remember('villa_primary_image_' . $this->id, now()->addHours(24), function () {
            $primaryImage = $this->primaryImage;
            return $primaryImage ? $primaryImage->url : asset('images/villa-placeholder.jpg');
        });
    }

    /**
     * Get the main image URL (alias for primary image).
     */
    public function getMainImageAttribute()
    {
        $primaryImage = $this->primaryImage;
        return $primaryImage ? $primaryImage->url : asset('images/villa-placeholder.jpg');
    }

    /**
     * Get the bookings for the villa.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the villa.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the approved reviews for the villa.
     */
    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->approved();
    }

    /**
     * Get the average rating for the villa.
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?: 0;
    }

    /**
     * Get the total number of approved reviews.
     */
    public function getReviewCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Get star rating as HTML.
     */
    public function getStarRatingAttribute()
    {
        $rating = round($this->average_rating, 1);
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } elseif ($i - 0.5 <= $rating) {
                $stars .= '<i class="fas fa-star-half-alt text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }

    /**
     * Get the features for the villa.
     */
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'villa_features');
    }

    /**
     * Get the users who favorited this villa.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'villa_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active villas.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured villas.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to include villas in a specific location.
     */
    public function scopeInLocation($query, $locationId)
    {
        if ($locationId) {
            return $query->where('location_id', $locationId);
        }
        return $query;
    }

    /**
     * Scope a query to filter villas by price range.
     */
    public function scopeByPriceRange($query, $min, $max)
    {
        if ($min) {
            $query->where('price_per_night', '>=', $min);
        }
        if ($max) {
            $query->where('price_per_night', '<=', $max);
        }
        return $query;
    }

    /**
     * Scope a query to filter villas by number of guests.
     */
    public function scopeByGuests($query, $guests)
    {
        if ($guests) {
            return $query->where('capacity', '>=', $guests);
        }
        return $query;
    }

    /**
     * Scope a query to filter villas by number of bedrooms.
     */
    public function scopeByBedrooms($query, $bedrooms)
    {
        if ($bedrooms) {
            return $query->where('bedrooms', '>=', $bedrooms);
        }
        return $query;
    }

    /**
     * Check if the villa is available between two dates.
     */
    public function isAvailable($checkInDate, $checkOutDate)
    {
        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->where(function ($query) use ($checkInDate, $checkOutDate) {
                    // Yeni rezervasyon mevcut rezervasyonun içinde başlıyor
                    $query->where('check_in', '<', $checkInDate)
                        ->where('check_out', '>', $checkInDate);
                })
                ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                    // Yeni rezervasyon mevcut rezervasyonun içinde bitiyor
                    $query->where('check_in', '<', $checkOutDate)
                        ->where('check_out', '>', $checkOutDate);
                })
                ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                    // Yeni rezervasyon mevcut rezervasyonu tamamen kapsıyor
                    $query->where('check_in', '>=', $checkInDate)
                        ->where('check_out', '<=', $checkOutDate);
                })
                ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                    // Mevcut rezervasyon yeni rezervasyonu tamamen kapsıyor
                    $query->where('check_in', '<=', $checkInDate)
                        ->where('check_out', '>=', $checkOutDate);
                });
            })
            ->exists();
    }

    /**
     * Get the features formatted as a string.
     */
    public function getFeatureListAttribute()
    {
        return $this->features->pluck('name')->implode(', ');
    }

    /**
     * Calculate the total price for a stay.
     */
    public function calculatePrice($checkInDate, $checkOutDate)
    {
        $checkIn = new \DateTime($checkInDate);
        $checkOut = new \DateTime($checkOutDate);
        $nights = $checkIn->diff($checkOut)->days;
        
        return $nights * $this->price_per_night;
    }
}
