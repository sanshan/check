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

Route::get('users/datatable', 'Api\UserController@dataTableIndex')->name('users.index.datatable');
Route::apiResource('users', 'Api\UserController');

Route::get('regions/{region}/users', 'Api\RegionController@getUsers');
Route::get('regions/datatable', 'Api\RegionController@dataTableIndex')->name('regions.index.datatable');
Route::apiResource('regions', 'Api\RegionController');

Route::get('typeofgasstations/datatable', 'Api\TypeOfGasStationController@dataTableIndex')->name('typeofgasstations.index.datatable');
Route::apiResource('typeofgasstations', 'Api\TypeOfGasStationController');

Route::get('positions/datatable', 'Api\PositionController@dataTableIndex')->name('positions.index.datatable');
Route::apiResource('positions', 'Api\PositionController');

Route::get('typeofchecklists/datatable', 'Api\TypeOfChecklistController@dataTableIndex')->name('typeofchecklists.index.datatable');
Route::apiResource('typeofchecklists', 'Api\TypeOfChecklistController');

Route::apiResource('roles', 'Api\RoleController');

Route::get('gasstations/datatable', 'Api\GasStationController@dataTableIndex')->name('gasstations.index.datatable');
Route::apiResource('gasstations', 'Api\GasStationController');

Route::get('sections/datatable', 'Api\SectionController@dataTableIndex')->name('sections.index.datatable');
Route::apiResource('sections', 'Api\SectionController');

Route::get('questions/datatable', 'Api\QuestionController@dataTableIndex')->name('questions.index.datatable');
Route::apiResource('questions', 'Api\QuestionController');

Route::get('templates/datatable', 'Api\TemplateController@dataTableIndex')->name('templates.index.datatable');
Route::apiResource('templates', 'Api\TemplateController');

Route::get('tasks/datatable', 'Api\TaskController@dataTableIndex')->name('tasks.index.datatable');
Route::apiResource('tasks', 'Api\TaskController');



Route::get('templates/{template}/questions', 'Api\TemplateController@questions');
Route::get('templates/{template}/questions/available', 'Api\QuestionController@available');
Route::patch('templates/{template}/questions/add', 'Api\TemplateController@addQuestion');
Route::put('templates/{template}/questions/remove', 'Api\TemplateController@removeQuestion');
//Route::put('templates/{template}/questions/remove', 'Api\TemplateController@removeQuestion');
Route::patch('templates/{template}/questions/{question}/positions/update', 'Api\TemplateController@updatePositions');
Route::get('templates/{template}/questions/{question}/positions/index', 'Api\TemplateController@indexPositions');

