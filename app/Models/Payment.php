<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'summon_id',
        'receipt_number',
        'amount_paid',
        'payment_method',
        'payment_datetime',
        'processed_by',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_datetime' => 'datetime',
    ];

    /**
     * Get the summon that this payment belongs to.
     */
    public function summon()
    {
        return $this->belongsTo(Summon::class);
    }
}
