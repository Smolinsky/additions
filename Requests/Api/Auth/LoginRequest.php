<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Api\Auth
 */
class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:' . config('validation.email_max_length'),
            'password' => 'required|max:' . config('validation.string_max_length'),
        ];
    }
}
