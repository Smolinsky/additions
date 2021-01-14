<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unit
 * @package App\Models
 *
 * @property-read string key
 * @property int order
 *
 * @mixin Eloquent
 */
class Unit extends Model
{
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $timestamps = false;

    public const TYPE_IMPERIAL = 'imperial';
    public const TYPE_METRIC = 'metric';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'order',
    ];
}
