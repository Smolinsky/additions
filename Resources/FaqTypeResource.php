<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FaqTypeResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property string slug
 * @property string name
 * @property int|null order
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read Collection faqs
 */
class FaqTypeResource extends JsonResource
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
            'slug' => $this->slug,
            'type' => $this->name,
            'faqs' => FaqResource::collection($this->whenLoaded('faqs')),
        ];
    }
}
