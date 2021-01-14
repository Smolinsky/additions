<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UnitResource;
use App\Repositories\Contracts\UnitInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class UnitController
 * @package App\Http\Controllers\Api
 */
class UnitController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, UnitInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $units = $this->repository->index($this->page, $this->perPage);

        return UnitResource::collection($units);
    }
}
