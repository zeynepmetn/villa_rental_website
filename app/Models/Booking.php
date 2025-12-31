<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'villa_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
        'notes'
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }

    /**
     * Get the customer who made the booking.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the review for this booking.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Check if this booking has a review.
     */
    public function hasReview()
    {
        return $this->review()->exists();
    }

    /**
     * Scope a query to only include active bookings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }

    /**
     * Scope a query to only include upcoming bookings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('check_in', '>=', now()->format('Y-m-d'))
            ->where('status', '!=', 'cancelled');
    }

    /**
     * Scope a query to only include past bookings.
     */
    public function scopePast($query)
    {
        return $query->where('check_out', '<', now()->format('Y-m-d'));
    }

    /**
     * Check if booking is upcoming.
     */
    public function isUpcoming()
    {
        return $this->check_in >= now()->format('Y-m-d');
    }

    /**
     * Check if booking is active (current).
     */
    public function isActive()
    {
        $today = now()->format('Y-m-d');
        return $this->check_in <= $today && $this->check_out >= $today && $this->status != 'cancelled';
    }

    /**
     * Check if booking is completed.
     */
    public function isCompleted()
    {
        return $this->check_out < now()->format('Y-m-d') && $this->status != 'cancelled';
    }

    /**
     * Check if booking can be cancelled by customer.
     */
    public function canBeCancelled()
    {
        // Check if booking is at least 3 days in the future
        return $this->status != 'cancelled' && 
               $this->check_in > now()->addDays(3)->format('Y-m-d');
    }

    /**
     * Get the number of nights for this booking.
     */
    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    /**
     * Get formatted status.
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Onay Bekliyor',
            'confirmed' => 'Onaylandı',
            'completed' => 'Tamamlandı',
            'cancelled' => 'İptal Edildi'
        ];

        return $labels[$this->status] ?? $this->status;
    }
}
