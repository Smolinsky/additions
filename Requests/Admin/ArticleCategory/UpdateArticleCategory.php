<?php

namespace App\Http\Requests\Admin\ArticleCategory;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateArticleCategory extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.article-category.edit', $this->articleCategory);
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
            'name' => 'string',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $articleCategory = $this->route('articleCategory');
        $id = $articleCategory ? $articleCategory->id : null;

        return [
            'name' => '',
            'slug' => "string|unique:article_categories,slug,$id",
            'order' => 'int',
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
