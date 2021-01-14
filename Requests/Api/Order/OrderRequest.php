<?php

namespace App\Http\Requests\Api\Order;

use App\Http\Requests\BaseRequest;

/**
 * Class OrderRequest
 * @package App\Http\Requests\Api\Order
 */
class OrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'nullable|int',
            'first_name' => 'nullable|string',
            'email' => 'nullable|string',
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }

}
