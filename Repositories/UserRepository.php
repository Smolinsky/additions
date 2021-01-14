<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserInterface
{
    public function findById($id, $with = []): ?User
    {
        /* @var User|null $user */
        $user = User::with($with)->find($id);

        return $user;
    }

    public function searchByEmail(string $email, $with = []): ?User
    {
        /* @var User $user */
        $user = User::with($with)->where('email', $email)->first();

        return $user;
    }

    public function search(int $page, int $perPage, $with = [], string $searchString = ''): LengthAwarePaginator
    {
        return User::with($with)
            ->where('name', 'like', "%$searchString%")
            ->paginate($perPage, ['*'], null, $page);
    }

    public function create(array $attributes): User
    {
        if (!empty($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        }

        /* @var User $user */
        $user = User::create($attributes);

        return $user;
    }

    public function update(User $user, array $attributes): User
    {
        $user->update($attributes);

        return $user;
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function delete($id): bool
    {
        return (bool)User::where('id', $id)->delete();
    }

    /**
     * @param User $user
     * @param string $newPassword
     */
    public function changePassword(User $user, string $newPassword)
    {
        $user->password = bcrypt($newPassword);
        $user->save();
    }
}
