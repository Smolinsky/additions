<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * Class Question
 * @package App\Models
 *
 * @property-read int id
 * @property int question_id
 * @property string answer
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Question question
 *
 * @mixin Eloquent
 */
class Answer extends Model
{
    use HasTranslations;

    public $translatable = [
        'answer'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'answer',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

}
