<?php

namespace App\Http\Requests\Admin\Product;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProduct extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.product.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param mixed $locale
     * @return array
     */
    public function translatableRules($locale): array
    {
        return [
            'name' => 'string|required',
            'description' => 'string|required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|int|exists:categories,id',
            'name' => 'required',
            'description' => 'required',
            'code' => 'required',
            'price' => 'required',
            'special' => 'nullable',
            'stock' => 'required',
            'order' => 'int',
            'discounts' => 'array|nullable',
            'discounts.*.product_id' => 'nullable|int',
            'discounts.*.quantity' => 'required|int',
            'discounts.*.percent' => 'required|between:0,99.99',
        ];
    }

    /**
     * @return string
     */
    public function getChosenLanguage(): string
    {
        return strtolower($this->importLanguage);
    }

    /**
     * @return mixed
     */
    public function getResolvedConflicts()
    {
        return $this->resolvedTranslations;
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
