<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ArticleCategoryResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property string slug
 * @property string|null name
 * @property int order
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read Collection articles
 */
class ArticleCategoryResource extends JsonResource
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
            'name' => $this->name,
        ];
    }
}
