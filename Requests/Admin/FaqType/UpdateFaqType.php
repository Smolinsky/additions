<?php

namespace App\Http\Requests\Admin\FaqType;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateFaqType extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.faq-type.edit', $this->faqType);
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
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $faqType = $this->route('faqType');
        $id = $faqType ? $faqType->id : null;

        return [
            'name' => 'required',
            'slug' => "string|unique:faq_types,slug,$id",
            'order' => 'int'
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
        $result = $this->validated();
        $result['slug'] = str_slug($result['slug']);

        return $result;
    }
}
