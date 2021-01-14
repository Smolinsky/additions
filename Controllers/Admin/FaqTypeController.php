<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqType\BulkDestroyFaqType;
use App\Http\Requests\Admin\FaqType\DestroyFaqType;
use App\Http\Requests\Admin\FaqType\IndexFaqType;
use App\Http\Requests\Admin\FaqType\StoreFaqType;
use App\Http\Requests\Admin\FaqType\UpdateFaqType;
use App\Models\FaqType;
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

class FaqTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexFaqType $request
     * @return array|Factory|View
     */
    public function index(IndexFaqType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(FaqType::class)->processRequestAndGet(
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

        return view('admin.faq-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.faq-type.create');

        return view('admin.faq-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFaqType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreFaqType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the FaqType
        FaqType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/faq-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/faq-types');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FaqType $faqType
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(FaqType $faqType)
    {
        $this->authorize('admin.faq-type.edit', $faqType);

        return view('admin.faq-type.edit', [
            'faqType' => $faqType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFaqType $request
     * @param FaqType $faqType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFaqType $request, FaqType $faqType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values FaqType
        $faqType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/faq-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/faq-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyFaqType $request
     * @param FaqType $faqType
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyFaqType $request, FaqType $faqType)
    {
        $faqType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFaqType $request
     * @return Response|bool
     * @throws Throwable
     */
    public function bulkDestroy(BulkDestroyFaqType $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    FaqType::whereIn('id', $bulkChunk)->delete();
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
