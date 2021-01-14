<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\BulkDestroyRole;
use App\Http\Requests\Admin\Role\DestroyRole;
use App\Http\Requests\Admin\Role\IndexRole;
use App\Http\Requests\Admin\Role\StoreRole;
use App\Http\Requests\Admin\Role\UpdateRole;
use App\Models\Role;
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
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $viewPath = 'admin.role';
    protected $guard = 'admin';

    /**
     * Display a listing of the resource.
     *
     * @param IndexRole $request
     * @return array|Factory|View
     */
    public function index(IndexRole $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Role::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'guard_name'],

            // set columns to searchIn
            ['id', 'name', 'guard_name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data];
        }

        return view('admin.role.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.role.create');

        $this->createNewPermissions();

        return view('admin.role.create', [
            'permissions' => $this->getAllPermissions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRole $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRole $request)
    {
        $sanitized = $request->getSanitized();

        $sanitized['guard_name'] = $this->guard;

        /* @var Role $role */
        $role = Role::create($sanitized);

        $role->permissions()->sync($request->input('selected_permissions', []));

        if ($request->ajax()) {
            return ['redirect' => url('admin/roles'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return void
     * @throws AuthorizationException
     */
    public function show(Role $role)
    {
        $this->authorize('admin.role.show', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('admin.role.edit', $role);

        $this->createNewPermissions();

        $role->load('permissions:id');

        $role->setAttribute('selected_permissions', $role->permissions->map(function ($item) {
            return $item->id;
        }));

        return view($this->viewPath . '.edit', [
            'role' => $role,
            'permissions' => $this->getAllPermissions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRole $request
     * @param Role $role
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRole $request, Role $role)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $role->update($sanitized);

        if ($request->has('selected_permissions')) {
            $role->permissions()->sync($request->input('selected_permissions', []));
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/roles'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRole $request
     * @param Role $role
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyRole $request, Role $role)
    {
        $role->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRole $request
     * @return Response|bool
     * @throws Exception
     */
    public function bulkDestroy(BulkDestroyRole $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Role::whereIn('id', $bulkChunk)->delete();
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    private function createNewPermissions()
    {
        $configPermissions = config('permission.permissions');
        $allPermissions = collect(array_flip($configPermissions));

        Permission::where('guard_name', $this->guard)->whereNotIn('name', $configPermissions)->delete();

        $dbPermissions = Permission::where('guard_name', $this->guard)
            ->get('name')
            ->keyBy('name')
            ->toArray();

        foreach ($allPermissions->except(array_keys($dbPermissions)) as $permissionName => $key) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => $this->guard
            ]);
        }
    }

    private function getAllPermissions()
    {
        return Permission::where('guard_name', $this->guard)->orderBy('guard_name')->orderBy('name')->get();
    }
}
