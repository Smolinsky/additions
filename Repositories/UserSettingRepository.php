<?php

namespace App\Repositories;

use App\Models\UserSetting;
use App\Repositories\Contracts\UserSettingInterface;

class UserSettingRepository implements UserSettingInterface
{
    public function get(int $userId): UserSetting
    {
        return UserSetting::where('user_id', $userId)->first();
    }

    public function update(UserSetting $setting, array $attributes): UserSetting
    {
        $setting->update($attributes);

        return $setting;
    }
}
