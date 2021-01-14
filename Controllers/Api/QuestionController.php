<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\QuestionResource;
use App\Repositories\Contracts\QuestionInterface;
use Illuminate\Http\Request;

/**
 * Class QuestionController
 * @package App\Http\Controllers\Api
 */
class QuestionController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, QuestionInterface $repository)
    {
        $this->repository = $repository;

        parent::__construct($request);
    }

    public function index()
    {
        $question = $this->repository->index($this->page, $this->perPage, ['subQuestion', 'answers']);

        return QuestionResource::collection($question);
    }
}
