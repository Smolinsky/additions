<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends ApiBaseController
{
    protected $allowsWith = ['address', 'setting'];

    /**
     * @return UserResource
     */
    public function me(): UserResource
    {
        $this->user->load($this->with);

        return new UserResource($this->user);
    }
}
