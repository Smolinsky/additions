<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    protected $fillable = [
        'name', 'guard_name',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];
}
