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
Route::get('regions/users', 'Api\RegionController@getUsers');
Route::apiResource('users', 'Api\UserController');
Route::apiResource('regions', 'Api\RegionController');
Route::apiResource('positions', 'Api\PositionController');
Route::apiResource('typeofgasstations', 'Api\TypeOfGasStationController');
Route::apiResource('typeofchecklists', 'Api\TypeOfChecklistController');
Route::apiResource('roles', 'Api\RoleController');
Route::apiResource('gasstations', 'Api\GasStationController');
Route::apiResource('sections', 'Api\SectionController');
Route::apiResource('questions', 'Api\QuestionController');
Route::apiResource('templates', 'Api\TemplateController');
Route::apiResource('tasks', 'Api\TaskController');



Route::get('templates/{template}/questions', 'Api\TemplateController@questions');
Route::get('templates/{template}/questions/available', 'Api\QuestionController@available');
Route::patch('templates/{template}/questions/add', 'Api\TemplateController@addQuestion');
Route::put('templates/{template}/questions/remove', 'Api\TemplateController@removeQuestion');
Route::put('templates/{template}/questions/remove', 'Api\TemplateController@removeQuestion');
Route::patch('templates/{template}/questions/{question}/positions/update', 'Api\TemplateController@updatePositions');
Route::get('templates/{template}/questions/{question}/positions/index', 'Api\TemplateController@indexPositions');

