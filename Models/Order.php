<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property int status
 * @property string first_name
 * @property string email
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Collection products
 *
 * @mixin Eloquent
 */
class Order extends Model
{
    use UuidTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'first_name', 'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    public function getFullPrice()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPriceForCount();
        }

        return $total;
    }
}
