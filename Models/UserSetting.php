<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSetting
 * @package App\Models
 *
 * @property-read int id
 * @property int user_id
 * @property string unit
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @mixin Eloquent
 */
class UserSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'unit',
    ];
}
