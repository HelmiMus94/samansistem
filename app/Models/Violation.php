<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'penalty_amount',
        'demerit_points',
        'category'
    ];

    public function summons()
    {
        return $this->hasMany(Summon::class);
    }
}