<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    // Define the table name (optional, but good practice)
    protected $table = 'role_user';

    // Disable timestamps (since they're already in the migration)
    public $timestamps = false;
}
