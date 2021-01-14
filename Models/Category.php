<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * Class Category
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property string name
 * @property string code
 * @property string description
 * @property string|null image
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Collection products
 *
 * @mixin Eloquent
 */
class Category extends Model implements HasMedia
{
    use HasTranslations, UuidTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use ProcessMediaTrait;

    public $translatable = [
        'name', 'description'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'description', 'order'
    ];

    /**
     * @var array
     */
    protected $appends = ['image'];

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

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
