<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * Class Question
 * @package App\Models
 *
 * @property-read int id
 * @property int parent_id
 * @property string question
 * @property string type
 * @property string answer_type
 * @property boolean with_text_answer
 * @property int order
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Collection answers
 * @property Collection subQuestion
 *
 * @mixin Eloquent
 */
class Question extends Model
{
    use HasTranslations;

    public $translatable = [
        'question'
    ];

    public const TYPE_QUESTION_STRING = 'string';
    public const TYPE_QUESTION_VIDEO = 'video';
    public const TYPE_ANSWER_RADIO = 'radio';
    public const TYPE_ANSWER_CHECKBOX = 'checkbox';
    public const TYPE_ANSWER_SELECT = 'select';

    public const  ALL_QUESTION_TYPES = [
        self::TYPE_QUESTION_STRING,
        self::TYPE_QUESTION_VIDEO
    ];

    public const ALL_ANSWER_TYPES = [
        self::TYPE_ANSWER_RADIO
//        self::TYPE_ANSWER_CHECKBOX,
//        self::TYPE_ANSWER_SELECT
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'question', 'type', 'answer_type', 'with_text_answer', 'order',
    ];

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return HasMany
     */
    public function subQuestion(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

}
