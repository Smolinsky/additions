<?php

namespace App\Http\Requests\Admin\ArticleCategory;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class StoreArticleCategory extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.article-category.create');
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
            'name' => 'required|string',
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
            'name' => 'required',
            'slug' => 'string|nullable|unique:article_categories',
            'order' => 'required|int',
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

        if (empty($result['slug'])) {
            $result['slug'] = str_slug(reset($result['name']));
        } else {
            $result['slug'] = str_slug($result['slug']);
        }

        return $result;
    }
}
