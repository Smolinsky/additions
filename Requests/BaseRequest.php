<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\ArrayRulesTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Class BaseRequest
 * @package App\Http\Requests
 */
abstract class BaseRequest extends FormRequest
{
    use ArrayRulesTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->getMessageBag()->getMessages();

//        foreach ($errors as $key => $error) {
//            foreach ($error as $_key => $e) {
//                preg_match_all(
//                    '/(?:^|\s)([a-zA-Z-]{1,}\.[a-zA-Z0-9\.-]{1,}|[a-zA-Z0-9-]{1,}\.[a-zA-Z\.-]{1,})(?:$|\s)/iUs',
//                    $e,
//                    $matches
//                );
//
//                if (!empty($matches[1])) {
//                    foreach ($matches[1] as $match) {
//                        trim($match, '.');
//
//                        $title = explode('.', $match);
//                        $title = trans('validation.attributes.'.array_pop($title));
//
//                        $errors[$key][$_key] = str_replace($match, $title, $e);
//                    }
//
//                    continue;
//                }
//            }
//        }

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        return $this->validated();
    }
}
