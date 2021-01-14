<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SystemParamResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property string type
 * @property string|null value
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 */
class SystemParamResource extends JsonResource
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
            'type' => $this->type,
            'value' => $this->value,
        ];
    }
}
