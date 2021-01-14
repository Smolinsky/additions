<?php

namespace App\Repositories;

use App\Models\Reminder;
use App\Repositories\Contracts\PasswordReminderInterface;
use DB;
use Exception;
use Str;

class PasswordReminderRepository implements PasswordReminderInterface
{
    public function findByCode(string $code): ?Reminder
    {
        /* @var Reminder $activationCode */
        $activationCode = Reminder::where(DB::raw('BINARY `code`'), $code)
            ->where('expired_at', '>', now())
            ->first();

        return $activationCode;
    }

    public function create(int $userId): Reminder
    {
        /* @var Reminder|null $activation */
        $activation = Reminder::create([
            'user_id' => $userId,
            'code' => Str::random(32),
            'expired_at' => now()->addMinutes(config('app.reset_password_email_timeout')),
        ]);

        return $activation;
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function delete($id): bool
    {
        return (bool)Reminder::where('id', $id)->delete();
    }

    /**
     * @param $userId
     * @return bool
     * @throws Exception
     */
    public function deleteAllForUser($userId): bool
    {
        return (bool)Reminder::where('user_id', $userId)->delete();
    }
}
