<?php

namespace App\Models;

use App\Models\Traits\SeoTrait;
use App\Models\Traits\UuidTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * Class Article
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property string slug
 * @property int category_id
 * @property string|null image
 * @property string title
 * @property string description
 * @property string|null alt
 * @property int|null time_to_read
 * @property bool is_show
 * @property string|null author
 * @property Carbon published_at
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read ArticleCategory category
 *
 * @mixin Eloquent
 */
class Article extends Model implements HasMedia
{
    use HasTranslations, UuidTrait;
    use SeoTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use ProcessMediaTrait;

    public $translatable = [
        'title', 'description', 'alt',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'category_id', 'title', 'description', 'alt', 'time_to_read', 'is_show', 'author', 'published_at',
    ];

    protected $dates = [
        'published_at'
    ];

    /**
     * @var array
     */
    protected $appends = ['image'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = str_slug($model->title);
            } else {
                $model->slug = str_slug($model->slug);
            }

            if (empty($model->author)) {
                $model->author = config('app.default_article_author', 'Heelsoverhead Team');
            }
        });

        static::updating(function (self $model) {
            $model->slug = str_slug($model->slug);

            if (empty($model->author)) {
                $model->author = config('app.default_article_author', 'Heelsoverhead Team');
            }
        });
    }

    /* ************************ MEDIA ************************ */

    /**
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')
            ->accepts('image/*');
    }

    /**
     * Register media conversions
     *
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->autoRegisterThumb200();
        /*$this->addMediaConversion('thumb_400')
            ->width(400)
            ->height(400)
            ->fit('crop', 400, 400)
            ->optimize()
            ->performOnCollections('image')
            ->nonQueued();*/
    }

    /**
     * Auto register thumb overridden
     * @throws InvalidManipulation
     */
    public function autoRegisterThumb200()
    {
        $this->getMediaCollections()->filter->isImage()->each(function ($mediaCollection) {
            $this->addMediaConversion('thumb_200')
                ->width(200)
                ->height(200)
                ->fit('crop', 200, 200)
                ->optimize()
                ->performOnCollections($mediaCollection->getName())
                ->nonQueued();
        });
    }

    /* ************************ RELATIONS ************************ */

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }
}
