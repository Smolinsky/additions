<?php

namespace App\Repositories\Contracts;

use App\Models\UserAccount;

interface UserAccountInterface
{
    public function searchBySocial(string $socialType, string $socialId, $with = []): ?UserAccount;

    public function searchByEmail(string $email, $with = []): ?UserAccount;

    public function create(array $attributes): UserAccount;

    public function update(UserAccount $userAccount, array $attributes): UserAccount;

    public function delete($id): bool;
}
