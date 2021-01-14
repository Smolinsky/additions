<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\BulkDestroyFaq;
use App\Http\Requests\Admin\Faq\DestroyFaq;
use App\Http\Requests\Admin\Faq\IndexFaq;
use App\Http\Requests\Admin\Faq\StoreFaq;
use App\Http\Requests\Admin\Faq\UpdateFaq;
use App\Models\Faq;
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

class FaqController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexFaq $request
     * @return array|Factory|View
     */
    public function index(IndexFaq $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Faq::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'short_description', 'is_show', 'order'],

            // set columns to searchIn
            ['id', 'title->en', 'short_description->en', 'is_show->en']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data];
        }

        return view('admin.faq.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.faq.create');

        return view('admin.faq.create', [
            'types' => FaqType::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFaq $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreFaq $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Faq
        Faq::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/faqs'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/faqs');
    }

    /**
     * Display the specified resource.
     *
     * @param Faq $faq
     * @return void
     * @throws AuthorizationException
     */
    public function show(Faq $faq)
    {
        $this->authorize('admin.faq.show', $faq);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faq $faq
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Faq $faq)
    {
        $this->authorize('admin.faq.edit', $faq);

        return view('admin.faq.edit', [
            'faq' => $faq,
            'types' => FaqType::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFaq $request
     * @param Faq $faq
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFaq $request, Faq $faq)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Faq
        $faq->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/faqs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/faqs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyFaq $request
     * @param Faq $faq
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyFaq $request, Faq $faq)
    {
        $faq->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFaq $request
     * @return Response|bool
     * @throws Throwable
     */
    public function bulkDestroy(BulkDestroyFaq $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Faq::whereIn('id', $bulkChunk)->delete();
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
