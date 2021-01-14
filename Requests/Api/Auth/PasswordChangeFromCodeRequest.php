<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

/**
 * Class PasswordChangeFromCodeRequest
 * @package App\Http\Requests\Api\Auth
 */
class PasswordChangeFromCodeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required|string|max:' . config('validation.string_max_length'),
            'password' => 'required|confirmed|min:' . config('validation.password_min_length') . '|max:' . config('validation.password_max_length'),
        ];
    }
}
