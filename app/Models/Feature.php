<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    /**
     * Get the villas that have this feature.
     */
    public function villas()
    {
        return $this->belongsToMany(Villa::class, 'villa_features');
    }
}
