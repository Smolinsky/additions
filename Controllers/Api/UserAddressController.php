<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserAddress\UserAddressUpdateRequest;
use App\Http\Resources\UserAddressResource;
use App\Repositories\Contracts\UserAddressInterface;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserAddressController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, UserAddressInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return UserAddressResource
     */
    public function index(): UserAddressResource
    {
        return new UserAddressResource($this->user->address);
    }

    /**
     * @param UserAddressUpdateRequest $request
     * @return UserAddressResource
     */
    public function update(UserAddressUpdateRequest $request): UserAddressResource
    {
        $address = $this->repository->update($this->user->address, $request->getSanitized());

        return new UserAddressResource($address);
    }
}
