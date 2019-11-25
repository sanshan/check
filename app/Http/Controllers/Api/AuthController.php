<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserInfoResource;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);


        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     *  User registration
     * @param Request $request
     * @return
     * @throws \Throwable
     */
//    public function registration(Request $request)
//    {
//        $user = DB::transaction(function () use ($request) {
//            $user = User::create([
//                'email'    => $request->email,
//                'password' => Hash::make($request->password),
//            ]);
//            $user->profile()->create([
//                'phone'      => 'phone',
//                'name'       => 'name',
//                'patronymic' => 'patronymic',
//                'surname'    => 'surname',
//                'role_id'    => 1,
//            ]);
//            $user->profile->regions()->attach([1]);
//            $user->profile->stations()->attach([1]);
//
//            return $user;
//        });
//
//        return $this->sendResponse(UserInfoResource::make($user), __('Record created successfully.'));
//    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function me()
//    {
//        return response()->json(auth()->user());
//    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function logout()
//    {
//        auth()->logout();
//
//        return response()->json(['message' => 'Successfully logged out']);
//    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\Response
     */
//    public function sendError($error, $errorMessages = [], $code = 404)
//    {
//        $response = [
//            'success' => false,
//            'message' => $error,
//        ];
//
//
//        if(!empty($errorMessages)){
//            $response['data'] = $errorMessages;
//        }
//
//
//        return response()->json($response, $code);
//    }
}
