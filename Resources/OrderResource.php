<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class OrderResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property int user_id
 * @property int status
 * @property string first_name
 * @property string email
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Collection products
 * @method getFullPrice()
 */
class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'first_name' => $this->first_name,
            'email' => $this->email,
            'products' => ProductResource::collection($this->products),
            'full_price' => $this->getFullPrice(),
        ];
    }
}
