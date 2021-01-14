<?php

namespace App\Repositories\Contracts;

use App\Models\UserSetting;

interface UserSettingInterface
{
    public function get(int $userId): UserSetting;

    public function update(UserSetting $setting, array $attributes): UserSetting;
}
