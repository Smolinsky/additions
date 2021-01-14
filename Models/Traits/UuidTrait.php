<?php

namespace App\Models\Traits;

use Str;

/**
 * Trait UuidTrait
 * @package App\Models\Traits
 */
trait UuidTrait
{
    protected static function bootUuidTrait()
    {
        static::creating(function (self $model) {
            $model->uuid = (string)Str::uuid();
        });
    }
}
