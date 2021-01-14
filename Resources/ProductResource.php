<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProductCategoryResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property int category_id
 * @property string image
 * @property string name
 * @property string description
 * @property int price
 * @property int special
 * @property int stock
 * @property int order
 * @property int code
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Collection category
 * @property Collection discounts
 * @method getPriceForCount()
 * @method getQuantityForProduct()
 */
class ProductResource extends JsonResource
{
    use ResponseTrait;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'category_id' => $this->category_id,
            'image' => $this->image ? asset($this->image) : null,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'special' => $this->special,
            'stock' => $this->stock,
            'code' => $this->code,
            'order' => $this->order,
            'category' => new ProductCategoryResource($this->category),
            'discounts' => ProductDiscountResource::collection($this->discounts),
            'basket_price_product' => $this->getPriceForCount(),
            'basket_quantity_product' => $this->getQuantityForProduct(),
        ];
    }
}
