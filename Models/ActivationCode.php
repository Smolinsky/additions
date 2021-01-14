<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ActivationCode
 * @package App\Models
 *
 * @property-read int id
 * @property int user_id
 * @property string code
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property User user
 *
 * @mixin Eloquent
 */
class ActivationCode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'code',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
