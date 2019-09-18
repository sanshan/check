<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use DB;
use Exception;
use Hash;
use App\Http\Controllers\Controller;
use App\User;
use Log;
use Throwable;


class UserController extends Controller
{

    public function index(UserRequest $request)
    {
        $title = $request->input('title');
        $users = User::when($title, function ($query) use ($title){
            return $query->whereHas('profile', function($query) use ($title){
                return $query->where('full_name', 'LIKE', "%$title%");
            })
            ->take(10);
        })->with('profile', 'profile.role', 'profile.regions', 'profile.stations')->get();

        return
            $title
                ? UserResource::collection($users)
                : datatables()->of(UserResource::collection($users))
                ->addColumn('DT_RowId', function($row){
                    return 'row_'.$row['id'];
                })->toJson();
    }

    /**
     * @param UserRequest $request
     * @return UserResource
     * @throws Throwable
     */
    public function store(UserRequest $request) : UserResource
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
        return UserResource::make($user);
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
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     * @throws Throwable
     */
    public function update(UserRequest $request, User $user) : UserResource
    {
        DB::transaction(function () use($request, $user) {
            $user->email = $request->email;
            $user->profile->phone = $request->phone;
            $user->profile->name = $request->name;
            $user->profile->patronymic = $request->patronymic;
            $user->profile->surname = $request->surname;
            $user->profile->role_id = $request->role_id;
            $user->save();
            $user->profile->save();
            $user->profile->regions()->sync($request->region_id);
            $user->profile->stations()->sync($request->gas_station_id);
        });
        return UserResource::make($user);
    }

    /**
     * @param User $user
     * @return UserResource
     * @throws Exception
     */
    public function destroy(User $user) : UserResource
    {
        $user->delete();
        return UserResource::make($user);
    }

}
