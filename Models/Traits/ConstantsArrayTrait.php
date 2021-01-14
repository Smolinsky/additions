<?php

namespace App\Models\Traits;

use ReflectionClass;

/**
 * Trait ConstantsArrayTrait
 * @package App\Models\Traits
 */
trait ConstantsArrayTrait
{
    public static function getConstantsByPrefix(string $prefix): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        $constants = $reflectionClass->getConstants();

        return array_filter(
            $constants,
            function ($key) use ($prefix) {
                return str_starts_with($key, $prefix);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
