<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserSettingResource
 * @package App\Http\Resources
 *
 * @property-read int id
 * @property int user_id
 * @property string unit
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 */
class UserSettingResource extends JsonResource
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
            'unit' => $this->unit,
        ];
    }
}
