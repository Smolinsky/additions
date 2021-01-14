<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserSetting\UserSettingUpdateRequest;
use App\Http\Resources\UserSettingResource;
use App\Repositories\Contracts\UserSettingInterface;
use Illuminate\Http\Request;

/**
 * Class UserSettingController
 * @package App\Http\Controllers\Api
 */
class UserSettingController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, UserSettingInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return UserSettingResource
     */
    public function index(): UserSettingResource
    {
        return new UserSettingResource($this->user->setting);
    }

    /**
     * @param UserSettingUpdateRequest $request
     * @return UserSettingResource
     */
    public function update(UserSettingUpdateRequest $request): UserSettingResource
    {
        $setting = $this->repository->update($this->user->setting, $request->getSanitized());

        return new UserSettingResource($setting);
    }
}
