<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', 'Api\UserController');
Route::apiResource('regions', 'Api\RegionController');
Route::apiResource('positions', 'Api\PositionController');
Route::apiResource('typeofgasstations', 'Api\TypeOfGasStationController');
Route::apiResource('typeofchecklists', 'Api\TypeOfChecklistController');
Route::apiResource('roles', 'Api\RoleController');
Route::apiResource('gasstations', 'Api\GasStationController');
