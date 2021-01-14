<?php

namespace App\Repositories;

use App\Models\ActivationCode;
use App\Repositories\Contracts\ActivationCodeInterface;
use DB;
use Exception;
use Str;

class ActivationCodeRepository implements ActivationCodeInterface
{
    public function findByCode(string $code): ?ActivationCode
    {
        /* @var ActivationCode $activationCode */
        $activationCode = ActivationCode::where(DB::raw('BINARY `code`'), $code)
            ->first();

        return $activationCode;
    }

    public function create(int $userId): ?ActivationCode
    {
        /* @var ActivationCode|null $activation */
        $activation = ActivationCode::create([
            'user_id' => $userId,
            'code' => Str::random(32)
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
        return (bool)ActivationCode::where('id', $id)->delete();
    }
}
