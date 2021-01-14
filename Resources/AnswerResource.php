<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class QuestionResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property int question_id
 * @property string answer
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property Question question
 *
 */
class AnswerResource extends JsonResource
{
    use ResponseTrait;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'answer' => $this->answer
        ];
    }
}
