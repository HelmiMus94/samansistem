<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'rental_number',
        'start_date',
        'end_date',
        'actual_return_date',
        'daily_rate',
        'total_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'actual_return_date' => 'datetime',
    ];

    /**
     * Get the customer associated with the rental.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the vehicle associated with the rental.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the summons associated with the rental.
     */
    public function summons()
    {
        return $this->hasMany(Summon::class);
    }

    /**
     * Check if rental is active during a specific date
     */
    public function isActiveAt($date)
    {
        return $date >= $this->start_date && $date <= ($this->actual_return_date ?? $this->end_date);
    }

    /**
     * Get the rental duration in days
     */
    public function getDurationAttribute()
    {
        $end = $this->actual_return_date ?? $this->end_date;
        return $end->diffInDays($this->start_date) + 1;
    }
}