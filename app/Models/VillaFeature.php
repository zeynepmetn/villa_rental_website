<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillaFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id',
        'name'
    ];

    protected $table = 'villa_features';

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class);
    }
}
