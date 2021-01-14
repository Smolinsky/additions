<?php

namespace App\Http\Requests\Admin\Article;

use App\Http\Requests\Admin\Seo\UpdateSeoBlock;
use App\Http\Requests\Traits\ArrayRulesTrait;
use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateArticle extends TranslatableFormRequest
{
    use ArrayRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.article.edit', $this->article);
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
            'title' => 'string',
            'alt' => 'nullable|string',
            'description' => 'string',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $article = $this->route('article');
        $id = $article ? $article->id : null;

        $rules = [
            'slug' => "string|unique:articles,slug,$id",
            'category_id' => 'int|exists:article_categories,id',
            'title' => '',
            'alt' => 'nullable',
            'description' => '',
            'time_to_read' => 'int',
            'is_show' => 'boolean',
            'author' => 'string|nullable',
            'published_at' => 'nullable|date'
        ];

        $this->addFieldsSubRules($rules, 'seo', (new UpdateSeoBlock())->rules());

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
