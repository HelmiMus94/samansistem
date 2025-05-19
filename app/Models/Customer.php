<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_number',
        'address',
        'phone',
        'email',
        'date_of_birth',
        'license_number'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function summons()
    {
        return $this->hasMany(Summon::class);
    }
}