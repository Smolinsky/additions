<?php

namespace App\Http\Requests\Api\Articles;

use App\Http\Requests\BaseRequest;

/**
 * Class ArticleIndexRequest
 * @package App\Http\Requests\Api\Articles
 */
class ArticleIndexRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'string',
        ];
    }
}
