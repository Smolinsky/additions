<?php

namespace App\Http\Requests\Api\UserSetting;

use App\Http\Requests\BaseRequest;

/**
 * Class UserSettingUpdateRequest
 * @package App\Http\Requests\Api\UserSetting
 */
class UserSettingUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unit' => 'string|exists:units,key',
        ];
    }
}
