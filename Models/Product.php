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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * Class Product
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property int category_id
 * @property string name
 * @property string code
 * @property string description
 * @property int price
 * @property int special
 * @property int stock
 * @property string|null image
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Collection discounts
 * @property mixed pivot
 *
 * @mixin Eloquent
 */
class Product extends Model implements HasMedia
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
        'category_id', 'name', 'code', 'description', 'price', 'special', 'stock', 'order'
    ];

    /**
     * @var array
     */
    protected $appends = ['image', 'total'];

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
            ->accepts('image/*')
            ->maxNumberOfFiles(10);
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
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function discounts(): HasMany
    {
        return $this->hasMany(ProductDiscount::class);
    }

    public function getTotalAttribute()
    {
        return $this->getPriceForCount();
    }

    public function getPriceForCount()
    {
        if (!is_null($this->pivot)) {
            foreach ($this->discounts as $discount) {
                if ($discount->quantity <= $this->pivot->quantity) {
                    $price = $this->pivot->quantity * $this->price;

                    return $price - ($price / 100 * $discount->percent);
                } elseif ($discount->quantity >= $this->pivot->quantity) {
                    return $this->pivot->quantity * $this->price;
                }
            }

            return $this->pivot->quantity * $this->price;
        }

        return $this->price;
    }

    public function getQuantityForProduct()
    {
        return $this->pivot->quantity;
    }

}
