<?php

namespace App\Models;

use LaravelEnso\Core\Models\User as CoreUser;
use Laravel\Cashier\Billable;

class User extends CoreUser
{
    use Billable;
    
    protected $fillable = ['person_id', 'group_id', 'role_id', 'email', 'is_active', 'email_verified_at', 'password', 'trial_ends_at'];

    protected $dates = [
        'created_at',
        'updated_at',
        'trial_ends_at'
    ];
}
