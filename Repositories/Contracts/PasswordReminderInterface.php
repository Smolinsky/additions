<?php

namespace App\Repositories\Contracts;

use App\Models\Reminder;

interface PasswordReminderInterface
{
    public function findByCode(string $code): ?Reminder;

    public function create(int $userId): Reminder;

    public function delete($id): bool;

    public function deleteAllForUser($userId): bool;
}
