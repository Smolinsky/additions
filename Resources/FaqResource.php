<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use App\Models\FaqType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FaqResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property int faq_type_id
 * @property string title
 * @property string short_description
 * @property string description
 * @property bool is_show
 * @property int|null order
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property FaqType type
 */
class FaqResource extends JsonResource
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
            'id' => $this->uuid,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
        ];
    }
}
