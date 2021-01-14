<?php

namespace App\Repositories\Contracts;

interface UuidFindInterface
{
    public function getIdByUuid(string $class, string $uuid, string $keyName = 'uuid'): ?int;
}
