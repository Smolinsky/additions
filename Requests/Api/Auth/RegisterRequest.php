<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:' . config('validation.string_max_length'),
            'last_name' => 'required|string|max:' . config('validation.string_max_length'),
            //'email' => 'required|email|unique:users|unique:user_accounts|max:' . config('validation.email_max_length'),
            'email' => 'required|email|unique:users|max:' . config('validation.email_max_length'),
            'password' => 'required|password_regex|confirmed|min:' . config('validation.password_min_length') . '|max:' . config('validation.password_max_length'),
        ];
    }
}
