<?php

namespace App\Http\Controllers\Api\Traits;

use App\Repositories\Contracts\UuidFindInterface;
use Exception;
use Log;

/**
 * Trait UuidFindTrait
 * @package App\Api\Controllers\Traits
 */
trait UuidFindTrait
{
    /**
     * @param string $class
     * @param string $uuid
     * @param string $keyName
     * @return int|null
     */
    public function getIdByUuid(string $class, string $uuid, string $keyName = 'uuid')
    {
        try {
            $repository = app()->make(UuidFindInterface::class);
        } catch (Exception $exception) {
            Log::error($exception);

            return null;
        }

        return $repository->getIdByUuid($class, $uuid, $keyName);
    }
}
