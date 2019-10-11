<?php

namespace App\Http\Controllers\Api;

use App\Classes\Filter\UserFilter;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserInfoResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserSelect2Resource;
use DB;
use Hash;
use App\Http\Controllers\Controller;
use App\Models\User;


class UserController extends Controller
{

    /**
     * @param UserFilter $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(UserFilter $filters)
    {
        $users = User::with('profile')->filter($filters)->take(10)->get();
        return UserSelect2Resource::collection($users);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $users = User::with('profile', 'profile.role', 'profile.regions', 'profile.stations')->get();

        return datatables()->of(UserResource::collection($users))
                ->addColumn('DT_RowId', function($row){
                    return 'row_'.$row['id'];
                })->toJson();
    }


    /**
     * @param UserStoreRequest $request
     * @return UserInfoResource
     * @throws \Throwable
     */
    public function store(UserStoreRequest $request) : UserInfoResource
    {
        $user = DB::transaction(function () use($request) {
            $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
            $password = substr($random, 0, 10);
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($password),
            ]);
            $user->profile()->create([
                'phone' => $request->phone,
                'name' => $request->name,
                'patronymic' => $request->patronymic,
                'surname' => $request->surname,
                'full_name' => $request->name. ' '.$request->patronymic.' '.$request->surname,
                'role_id' => $request->role_id,
            ]);
            $user->profile->regions()->attach($request->region_id);
            $user->profile->stations()->attach($request->gas_station_id);

            return $user;
        });
        return UserInfoResource::make($user);
    }


    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user) : UserResource
    {
        $user->load('profile', 'profile.role', 'profile.stations', 'profile.regions');
        return UserResource::make($user);
    }


    /**
     * @param UserUpdateRequest $request
     * @param User $user
     * @return UserInfoResource
     * @throws \Throwable
     */
    public function update(UserUpdateRequest $request, User $user) : UserInfoResource
    {
        $user = DB::transaction(function () use($request, $user) {
            $user->email = $request->email;
            $user->profile->phone = $request->phone;
            $user->profile->name = $request->name;
            $user->profile->patronymic = $request->patronymic;
            $user->profile->surname = $request->surname;
            $user->profile->full_name = $request->name. ' '.$request->patronymic.' '.$request->surname;
            $user->profile->role_id = $request->role_id;
            $user->save();
            $user->profile->save();
            $user->profile->regions()->sync($request->region_id);
            $user->profile->stations()->sync($request->gas_station_id);

            return $user;
        });
        return UserInfoResource::make($user);
    }


    /**
     * @param User $user
     * @return UserInfoResource
     * @throws \Exception
     */
    public function destroy(User $user) : UserInfoResource
    {
        $user->delete();
        return UserInfoResource::make($user);
    }

}
