<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\BulkDestroyUser;
use App\Http\Requests\Admin\User\DestroyUser;
use App\Http\Requests\Admin\User\IndexUser;
use App\Http\Requests\Admin\User\StoreUser;
use App\Http\Requests\Admin\User\UpdateUser;
use App\Models\User;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
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

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexUser $request
     * @return array|Factory|View
     */
    public function index(IndexUser $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(User::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'last_name', 'email'],

            // set columns to searchIn
            ['id', 'first_name', 'last_name', 'email']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data];
        }

        return view('admin.user.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.user.create');

        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreUser $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the User
        User::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/users'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return void
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('admin.user.show', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('admin.user.edit', $user);

        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return array|RedirectResponse|Redirector
     * @throws Exception
     */
    public function update(UpdateUser $request, User $user)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values User
        $user->update($sanitized);
        if (isset($sanitized['email_verified_at'])) {
            $user->email_verified_at = new Carbon($sanitized['email_verified_at']);
            $user->save();
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/users'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUser $request
     * @param User $user
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyUser $request, User $user)
    {
        $user->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyUser $request
     * @return Response|bool
     * @throws Throwable
     */
    public function bulkDestroy(BulkDestroyUser $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    User::whereIn('id', $bulkChunk)->delete();
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
