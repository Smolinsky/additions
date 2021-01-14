<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleCategory\BulkDestroyArticleCategory;
use App\Http\Requests\Admin\ArticleCategory\DestroyArticleCategory;
use App\Http\Requests\Admin\ArticleCategory\IndexArticleCategory;
use App\Http\Requests\Admin\ArticleCategory\StoreArticleCategory;
use App\Http\Requests\Admin\ArticleCategory\UpdateArticleCategory;
use App\Models\ArticleCategory;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ArticleCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexArticleCategory $request
     * @return array|Factory|View
     */
    public function index(IndexArticleCategory $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ArticleCategory::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'order'],

            // set columns to searchIn
            ['id', 'name->en', 'order']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data];
        }

        return view('admin.article-category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.article-category.create');

        return view('admin.article-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleCategory $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreArticleCategory $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ArticleCategory
        ArticleCategory::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/article-categories'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/article-categories');
    }

    /**
     * Display the specified resource.
     *
     * @param ArticleCategory $articleCategory
     * @return void
     * @throws AuthorizationException
     */
    public function show(ArticleCategory $articleCategory)
    {
        $this->authorize('admin.article-category.show', $articleCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ArticleCategory $articleCategory
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(ArticleCategory $articleCategory)
    {
        $this->authorize('admin.article-category.edit', $articleCategory);

        return view('admin.article-category.edit', [
            'articleCategory' => $articleCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleCategory $request
     * @param ArticleCategory $articleCategory
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateArticleCategory $request, ArticleCategory $articleCategory)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ArticleCategory
        $articleCategory->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/article-categories'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/article-categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyArticleCategory $request
     * @param ArticleCategory $articleCategory
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyArticleCategory $request, ArticleCategory $articleCategory)
    {
        $articleCategory->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyArticleCategory $request
     * @return Response|bool
     * @throws Throwable
     */
    public function bulkDestroy(BulkDestroyArticleCategory $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ArticleCategory::whereIn('id', $bulkChunk)->delete();
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
