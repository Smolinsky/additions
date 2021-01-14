<?php

namespace App\Http\Requests\Admin\Seo;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateSeoBlock extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.article.create');
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
            'title' => 'string|nullable',
            'description' => 'string|nullable',
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
        return $this->validated();
    }
}
