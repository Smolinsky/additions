<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CustomerResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property string|null first_name
 * @property string|null last_name
 * @property-read string|null email
 * @property-read Carbon|null email_verified_at
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read Collection accounts
 * @property-read Address address
 */
class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'is_email_confirmed' => (bool)$this->email_verified_at,
            'address' => new UserAddressResource($this->whenLoaded('address')),
            'setting' => new UserSettingResource($this->whenLoaded('setting')),
        ];
    }
}
