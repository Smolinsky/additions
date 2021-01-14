<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

/**
 * Class PasswordRemindRequest
 * @package App\Http\Requests\Api\Auth
 */
class PasswordRemindRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users|max:' . config('validation.string_max_length')
        ];
    }
}
