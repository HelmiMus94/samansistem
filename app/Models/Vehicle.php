<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'make',
        'model',
        'year',
        'color',
        'type',
        'status',
        'daily_rate'
    ];

    /**
     * Get the rentals associated with the vehicle.
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get summons through rentals
     */
    public function summons()
    {
        return $this->hasManyThrough(Summon::class, Rental::class);
    }
}