<?php

namespace App\Http\Resources;

use App\Models\SeoBlock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SeoBlockResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string title
 * @property string description
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read SeoBlock|null seo
 */
class SeoBlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
