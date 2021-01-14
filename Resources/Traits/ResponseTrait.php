<?php

namespace App\Http\Resources\Traits;

use App\Services\ImageService;
use Carbon\Carbon;

/**
 * Trait ResponseTrait
 * @package App\Http\Resources\Traits
 */
trait ResponseTrait
{
    /**
     * Convert Carbon time to date string response format
     *
     * @param Carbon|null $date
     * @return string|null
     */
    public function getDate(?Carbon $date): ?string
    {
        return is_null($date) ? null : $date->toDateString();
    }

    /**
     * Convert Carbon time to date time string response format
     *
     * @param Carbon|null $date
     * @return string|null
     */
    public function getDateTime(?Carbon $date): ?string
    {
        return is_null($date) ? null : $date->toDateTimeString();
    }

    /**
     * Convert image path to response format
     *
     * @param string|null $file_name
     * @return string|null
     */
    public function getImageUrl(?string $file_name): ?string
    {
        return ImageService::getUrlByPath($file_name);
    }
}
