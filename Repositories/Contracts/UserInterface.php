<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function findById($id, $with = []): ?User;

    public function searchByEmail(string $email, $with = []): ?User;

    public function search(int $page, int $perPage, $with = [], string $searchString = ''): LengthAwarePaginator;

    public function create(array $attributes): User;

    public function update(User $user, array $attributes): User;

    public function delete($id): bool;

    public function changePassword(User $user, string $newPassword);
}
