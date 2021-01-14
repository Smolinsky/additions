<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class ConfirmEmailRequest extends BaseRequest
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
            'code' => 'required|string|max:' . config('validation.string_max_length'),
        ];
    }
}
