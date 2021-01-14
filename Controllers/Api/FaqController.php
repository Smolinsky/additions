<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FaqResource;
use App\Repositories\Contracts\FaqInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class FaqController
 * @package App\Http\Controllers\Api
 */
class FaqController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, FaqInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getTopList(): AnonymousResourceCollection
    {
        $faqs = $this->repository->index($this->page, $this->perPage, true);

        return FaqResource::collection($faqs);
    }
}
