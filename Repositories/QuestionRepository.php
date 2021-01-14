<?php

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\Contracts\QuestionInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuestionRepository implements QuestionInterface
{
    public function index(int $page, int $perPage, $with = []): LengthAwarePaginator
    {
        return Question::with($with)
            ->whereNull('parent_id')
            ->paginate($perPage, ['*'], null, $page);
    }
}
