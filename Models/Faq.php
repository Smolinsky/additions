<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * Class Faq
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property int faq_type_id
 * @property string title
 * @property string short_description
 * @property string description
 * @property bool is_show
 * @property int|null order
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property FaqType type
 *
 * @mixin Eloquent
 */
class Faq extends Model
{
    use HasTranslations, UuidTrait;

    public $translatable = [
        'title', 'short_description', 'description'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'faq_type_id', 'title', 'short_description', 'description', 'is_show', 'order',
    ];

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(FaqType::class);
    }
}
