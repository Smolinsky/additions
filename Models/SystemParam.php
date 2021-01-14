<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemParam
 * @package App\Models
 *
 * @property-read int id
 * @property string type
 * @property string|null value
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @mixin Eloquent
 */
class SystemParam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'value',
    ];
}
