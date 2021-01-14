<?php

namespace App\Http\Requests\Admin\Question;

use App\Models\Question;
use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;

class StoreQuestion extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.question.create');
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
            'question' => 'string|required',
            'answers.*.answer' => 'required|string|max:255',
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
            'question' => 'required',
            'answer_type' => 'required|string|in:' . implode(',', Question::ALL_ANSWER_TYPES),
            'order' => 'required|int',
            'parent_id' => 'nullable|int|exists:questions,id',
            'type' => 'required|string|in:' . implode(',', Question::ALL_QUESTION_TYPES),
            'with_text_answer' => 'required|boolean',
            'answers' => 'array|nullable',
            'answers.*.id' => 'nullable|int',
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
