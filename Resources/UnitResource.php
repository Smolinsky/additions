<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UnitResource
 * @package App\Http\Resources
 *
 * @property-read string key
 */
class UnitResource extends JsonResource
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
            'key' => $this->key,
            'name' => trans('admin.units.' . $this->key),
        ];
    }
}
