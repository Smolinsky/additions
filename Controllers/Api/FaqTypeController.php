<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FaqTypeResource;
use App\Repositories\Contracts\FaqTypeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class FaqTypeController
 * @package App\Http\Controllers\Api
 */
class FaqTypeController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, FaqTypeInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $params = $this->repository->index($this->page, $this->perPage, ['faqs']);

        return FaqTypeResource::collection($params);
    }
}
