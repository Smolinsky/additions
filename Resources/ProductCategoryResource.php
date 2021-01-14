<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProductCategoryResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string uuid
 * @property string|null image
 * @property string name
 * @property string description
 * @property int order
 * @property int code
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 */
class ProductCategoryResource extends JsonResource
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
            'image' => $this->image ? asset($this->image) : null,
            'name' => $this->name,
            'description' => $this->description,
            'code' => $this->code,
            'order' => $this->order,
        ];
    }
}
