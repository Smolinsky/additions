<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SystemParam\IndexSystemParam;
use App\Http\Requests\Admin\SystemParam\UpdateSystemParam;
use App\Models\SystemParam;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class SystemParamController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSystemParam $request
     * @return array|Factory|View
     */
    public function index(IndexSystemParam $request)
    {
        $this->createAllSystemParams();

        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SystemParam::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'type', 'value'],

            // set columns to searchIn
            ['id', 'type', 'value']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data];
        }

        return view('admin.system-param.index', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SystemParam $systemParam
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(SystemParam $systemParam)
    {
        $this->authorize('admin.system-param.edit', $systemParam);

        return view('admin.system-param.edit', [
            'systemParam' => $systemParam,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSystemParam $request
     * @param SystemParam $systemParam
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSystemParam $request, SystemParam $systemParam)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SystemParam
        $systemParam->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/system-params'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/system-params');
    }

    private function createAllSystemParams()
    {
        foreach (config('system_type_params') as $type => $value) {
            SystemParam::firstOrCreate([
                'type' => $type
            ],
                [
                    'value' => $value
                ]);
        }
    }
}
