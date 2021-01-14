<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;
use App\Models\UserAccount;

/**
 * Class LoginBySocialiteRequest
 * @package App\Http\Requests\Api\Auth
 */
class LoginBySocialiteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:' . implode(',', UserAccount::ALL_TYPES),
            'code' => 'required|string|max:' . config('validation.social_code_max_length'),
        ];
    }
}
