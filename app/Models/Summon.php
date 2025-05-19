<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Summon extends Model
{
    use HasFactory;

    protected $fillable = [
        'summons_number',
        'rental_id',
        'violation_id',
        'issue_datetime',
        'location',
        'officer_name',
        'officer_badge_number',
        'officer_department',
        'comments',
        'total_amount',
        'status_id',
        'due_date',
        'photo_evidence',
        'recorded_by_user_id'
    ];

    protected $casts = [
        'issue_datetime' => 'datetime',
        'due_date' => 'date',
    ];

    /**
     * Get the rental associated with the summon.
     */
    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    /**
     * Get the violation associated with the summon.
     */
    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }

    /**
     * Get the status associated with the summon.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the payments associated with the summon.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the user who recorded this summon.
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by_user_id');
    }

    /**
     * Get the total amount paid for this summon.
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments->sum('amount_paid');
    }

    /**
     * Get the remaining balance for this summon.
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->total_amount - $this->total_paid;
    }

    /**
     * Check if the summon is fully paid.
     */
    public function isPaid()
    {
        return $this->remaining_balance <= 0;
    }

    /**
     * Check if the summon is overdue.
     */
    public function isOverdue()
    {
        return $this->due_date < now() && !$this->isPaid();
    }
}

class RoleUser extends Pivot
{
    protected $table = 'role_user';
    public $timestamps = false;

    protected $fillable = ['role_id', 'user_id'];

    // Validate that both role_id and user_id are present
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($roleUser) {
            if (!$roleUser->role_id || !$roleUser->user_id) {
                throw new \Exception('Both role_id and user_id are required');
            }
        });
    }
}