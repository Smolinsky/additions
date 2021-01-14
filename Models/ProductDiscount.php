<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductDiscount
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property int product_id
 * @property int quantity
 * @property int percent
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @mixin Eloquent
 */
class ProductDiscount extends Model
{
    use UuidTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'quantity', 'percent',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
