<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserAccount
 * @package App\Models
 *
 * @property-read int id
 * @property int user_id
 * @property string type
 * @property string social_id
 * @property string|null email
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property User user
 *
 * @mixin Eloquent
 */
class UserAccount extends Model
{
    public const TYPE_GOOGLE = 'google';
    public const TYPE_FACEBOOK = 'facebook';

    public const ALL_TYPES = [
        self::TYPE_GOOGLE,
        self::TYPE_FACEBOOK,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'social_id', 'email',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
