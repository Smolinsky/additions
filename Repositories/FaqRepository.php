<?php

namespace App\Repositories;

use App\Models\Faq;
use App\Repositories\Contracts\FaqInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FaqRepository implements FaqInterface
{
    public function index(int $page, int $perPage, bool $is_show = null): LengthAwarePaginator
    {
        $query = Faq::query();

        if (!is_null($is_show)) {
            $query->where('is_show', $is_show);
        }

        return $query
            ->orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }

    /**
     * @param int|string $faqTypeId
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchByTypeId($faqTypeId, int $page, int $perPage): LengthAwarePaginator
    {
        $query = Faq::where('faq_type_id', $faqTypeId);

        return $query
            ->orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }
}
