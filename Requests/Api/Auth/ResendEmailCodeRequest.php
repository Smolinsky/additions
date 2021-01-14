<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

/**
 * Class ResendEmailCodeRequest
 * @package App\Http\Requests\Api\Auth
 */
class ResendEmailCodeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users|max:' . config('validation.email_max_length')
        ];
    }
}
