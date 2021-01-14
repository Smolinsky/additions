<?php

namespace App\Http\Requests\Api\UserAddress;

use App\Http\Requests\BaseRequest;

/**
 * Class UserAddressUpdateRequest
 * @package App\Http\Requests\Api\UserAddress
 */
class UserAddressUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country' => 'string|max:' . config('validation.string_max_length'),
            'city' => 'string|max:' . config('validation.string_max_length'),
            'street' => 'string|max:' . config('validation.string_max_length'),
            'house' => 'string|max:' . config('validation.string_max_length'),
            'postal_code' => 'string|max:' . config('validation.string_max_length'),
        ];
    }
}
