<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * Class ArticleCategory
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property string slug
 * @property string|null name
 * @property int order
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read Collection articles
 *
 * @mixin Eloquent
 */
class ArticleCategory extends Model
{
    use HasTranslations, UuidTrait;

    public $translatable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name', 'order',
    ];

    /* ************************ RELATIONS ************************ */

    /**
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
