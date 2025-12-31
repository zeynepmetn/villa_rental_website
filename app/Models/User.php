<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'profile_image',
        'avatar',
        'city',
        'birth_date',
        'gender',
        'bio',
        'notifications_email',
        'notifications_sms',
        'language',
        'currency',
        'profile_public',
        'show_booking_history',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'last_login_at' => 'datetime',
        'notifications_email' => 'boolean',
        'notifications_sms' => 'boolean',
        'profile_public' => 'boolean',
        'show_booking_history' => 'boolean',
    ];

    /**
     * Get the villas that belong to the user (if realtor)
     */
    public function villas()
    {
        return $this->hasMany(Villa::class, 'realtor_id');
    }

    /**
     * Get bookings made by the user (if customer)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    /**
     * Get the favorite villas for the user
     */
    public function favorites()
    {
        return $this->belongsToMany(Villa::class, 'favorites', 'user_id', 'villa_id')
            ->withTimestamps();
    }

    /**
     * Check if a villa is in the user's favorites
     */
    public function hasFavorited(Villa $villa)
    {
        return $this->favorites()->where('villa_id', $villa->id)->exists();
    }

    /**
     * Check if user is a realtor
     */
    public function isRealtor()
    {
        return $this->hasRole('realtor');
    }

    /**
     * Check if user is a customer
     */
    public function isCustomer()
    {
        return $this->hasRole('customer');
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
