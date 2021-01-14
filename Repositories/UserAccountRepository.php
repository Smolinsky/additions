<?php

namespace App\Repositories;

use App\Models\UserAccount;
use App\Repositories\Contracts\UserAccountInterface;

class UserAccountRepository implements UserAccountInterface
{
    public function searchBySocial(string $socialType, string $socialId, $with = []): ?UserAccount
    {
        /* @var UserAccount $account */
        $account = UserAccount::with($with)
            ->where('type', $socialType)
            ->where('social_id', $socialId)
            ->first();

        return $account;
    }

    public function searchByEmail(string $email, $with = []): ?UserAccount
    {
        /* @var UserAccount $account */
        $account = UserAccount::with($with)->where('email', $email)->first();

        return $account;
    }

    public function create(array $attributes): UserAccount
    {
        /* @var UserAccount $account */
        $account = UserAccount::create($attributes);

        return $account;
    }

    public function update(UserAccount $userAccount, array $attributes): UserAccount
    {
        $userAccount->update($attributes);

        return $userAccount;
    }

    public function delete($id): bool
    {
        return (bool)UserAccount::where('id', $id)->delete();
    }
}
