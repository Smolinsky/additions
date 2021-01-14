<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SystemParamResource;
use App\Repositories\Contracts\SystemParamInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class SystemParamController
 * @package App\Http\Controllers\Api
 */
class SystemParamController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, SystemParamInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $params = $this->repository->index($this->page, $this->perPage);

        return SystemParamResource::collection($params);
    }
}
