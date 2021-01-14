<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class QuestionResource
 * @package App\Http\Resources
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
 */
class QuestionResource extends JsonResource
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
            'question' => $this->question,
            'type' => $this->type,
            'answer_type' => $this->answer_type,
            'with_text_answer' => $this->with_text_answer,
            'order' => $this->order,
            'sub_question' => self::collection($this->subQuestion),
            'answers' => AnswerResource::collection($this->answers)
        ];
    }
}
