<?php

namespace App\Repositories;

use App\Repositories\Contracts\UuidFindInterface;
use Eloquent;

class UuidFindRepository implements UuidFindInterface
{
    public function getIdByUuid(string $class, string $uuid, string $keyName = 'uuid'): ?int
    {
        /* @var Eloquent $model */
        $model = $class;
        $object = $model::where($keyName, $uuid)->first();

        return $object ? $object->{$object->getRouteKeyName()} : null;
    }
}
