<?php

namespace App\Repositories\Contracts;

use App\Models\ActivationCode;

interface ActivationCodeInterface
{
    public function findByCode(string $code): ?ActivationCode;

    public function create(int $userId): ?ActivationCode;

    public function delete($id): bool;
}
