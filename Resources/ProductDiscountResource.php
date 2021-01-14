<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProductDiscountResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property int product_id
 * @property int quantity
 * @property int percent
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 *
 */
class ProductDiscountResource extends JsonResource
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
            'id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'percent' => $this->percent,
        ];
    }
}
