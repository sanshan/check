<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Role;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index() : AnonymousResourceCollection
    {
        $roles = Role::all();
        return RoleResource::collection($roles);
    }

    /**
     * @param RoleRequest $request
     * @return RoleResource
     */
    public function store(RoleRequest $request) : RoleResource
    {
        $role = Role::create($request->validated());
        return RoleResource::make($role);
    }

    /**
     * @param Role $role
     * @return RoleResource
     */
    public function show(Role $role) : RoleResource
    {
        return RoleResource::make($role);
    }

    /**
     * @param RoleRequest $request
     * @param Role $role
     * @return RoleResource
     */
    public function update(RoleRequest $request, Role $role) : RoleResource
    {
        $role->fill($request->except('role_id'));
        $role->save();
        return RoleResource::make($role);
    }

    /**
     * @param Role $role
     * @return RoleResource
     * @throws Exception
     */
    public function destroy(Role $role) : RoleResource
    {
        $role->delete();
        return RoleResource::make($role);
    }
}
