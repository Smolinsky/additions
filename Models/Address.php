<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package App\Models
 *
 * @property-read int id
 * @property int user_id
 * @property string|null country
 * @property string|null city
 * @property Carbon|null street
 * @property string|null house
 * @property string|null postal_code
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @mixin Eloquent
 */
class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'country', 'city', 'street', 'house', 'postal_code',
    ];
}
