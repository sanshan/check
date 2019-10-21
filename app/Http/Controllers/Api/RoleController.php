<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Role\RoleIndexRequest;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;


class RoleController extends BaseController
{

    /**
     * @param RoleIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(RoleIndexRequest $request)
    {
        $roles = Role::filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(RoleResource::collection($roles), __('Data retrieved successfully.'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create($request->validated());

        return $this->sendResponse(RoleResource::make($role), __('Data created successfully.'));
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $this->sendResponse(RoleResource::make($role), __('Data retrieved successfully.'));
    }

    /**
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->fill($request->except('role_id'));
        $role->save();

        return $this->sendResponse(RoleResource::make($role), __('Record updated successfully.'));
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->sendResponse(RoleResource::make($role), __('Record deleted successfully.'));
    }
}
