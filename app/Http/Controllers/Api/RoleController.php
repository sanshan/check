<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleIndexRequest;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;


class RoleController extends Controller
{

    public function index(RoleIndexRequest $request)
    {
        $roles = Role::filter($request)
            ->take(10)
            ->get();

        return RoleResource::collection($roles);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $roles = Role::get();

        return datatables()->of(RoleResource::collection($roles))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();
    }

    /**
     * @param RoleStoreRequest $request
     * @return RoleResource
     */
    public function store(RoleStoreRequest $request): RoleResource
    {
        $role = Role::create($request->validated());
        return RoleResource::make($role);
    }

    /**
     * @param Role $role
     * @return RoleResource
     */
    public function show(Role $role): RoleResource
    {
        return RoleResource::make($role);
    }

    /**
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return RoleResource
     */
    public function update(RoleUpdateRequest $request, Role $role): RoleResource
    {
        $role->fill($request->except('role_id'));
        $role->save();
        return RoleResource::make($role);
    }

    /**
     * @param Role $role
     * @return RoleResource
     * @throws \Exception
     */
    public function destroy(Role $role): RoleResource
    {
        $role->delete();
        return RoleResource::make($role);
    }
}
