<?php

namespace App\Http\Requests\Admin\Article;

use App\Http\Requests\Admin\Seo\StoreSeoBlock;
use App\Http\Requests\Traits\ArrayRulesTrait;
use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class StoreArticle extends TranslatableFormRequest
{
    use ArrayRulesTrait;

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
            'title' => 'required|string',
            'alt' => 'nullable|string',
            'description' => 'required|string',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'slug' => 'string|nullable|unique:articles',
            'category_id' => 'required|int|exists:article_categories,id',
            'title' => 'required',
            'alt' => 'nullable',
            'description' => 'required',
            'time_to_read' => 'required|int',
            'is_show' => 'required|boolean',
            'author' => 'string|nullable',
            'published_at' => 'nullable|date'
        ];

        $this->addFieldsSubRules($rules, 'seo', (new StoreSeoBlock())->rules(), true);

        return $rules;
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
