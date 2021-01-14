<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use App\Models\SeoBlock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ArticleResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property string slug
 * @property string image
 * @property string title
 * @property string description
 * @property string|null alt
 * @property int|null time_to_read
 * @property bool is_show
 * @property string|null author
 * @property Carbon published_at
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read SeoBlock|null seo
 */
class ArticleResource extends JsonResource
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
            'image' => $this->image ? asset($this->image) : null,
            'alt' => $this->alt,
            'time_to_read' => $this->time_to_read,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'published_at' => $this->getDateTime($this->published_at),
            'category' => new ArticleCategoryResource($this->whenLoaded('category')),
            'seo' => new SeoBlockResource($this->seo),
        ];
    }
}
