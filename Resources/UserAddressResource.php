<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserAddressResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property int user_id
 * @property string|null country
 * @property string|null city
 * @property Carbon|null street
 * @property string|null house
 * @property string|null postal_code
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 */
class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'country' => $this->country,
            'city' => $this->city,
            'street' => $this->street,
            'house' => $this->house,
            'postal_code' => $this->postal_code,
        ];
    }
}
