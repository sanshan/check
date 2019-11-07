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

Route::get('sections/{section}/questions/datatable', 'Api\QuestionController@dataTableIndex')->name('sections.questions.index.datatable');
Route::apiResource('sections/{section}/questions', 'Api\QuestionController');

Route::get('templates/datatable', 'Api\TemplateController@dataTableIndex')->name('templates.index.datatable');
Route::apiResource('templates', 'Api\TemplateController');

Route::get('tasks/datatable', 'Api\TaskController@dataTableIndex')->name('tasks.index.datatable');
Route::apiResource('tasks', 'Api\TaskController');

Route::get('templates/{template}/sections', 'Api\TemplateSectionController@dataTableIndex')->name('templates.sections.index.datatable');
Route::post('templates/{template}/sections', 'Api\TemplateSectionController@store')->name('templates.sections.store');
Route::patch('templates/{template}/sections/{section}', 'Api\TemplateSectionController@update')->name('templates.sections.update');
Route::delete('templates/{template}/sections', 'Api\TemplateSectionController@destroy')->name('templates.sections.destroy');

Route::get('templates/{template}/sections/{section}/questions', 'Api\TemplateSectionQuestionController@index')->name('templates.sections.questions.index');
Route::post('templates/{template}/sections/{section}/questions', 'Api\TemplateSectionQuestionController@store')->name('templates.sections.questions.store');
Route::delete('templates/{template}/sections/{section}/questions', 'Api\TemplateSectionQuestionController@destroy')->name('templates.sections.questions.destroy');

Route::get('templates/{template}/sections/{ts}/questions/{tsq}/positions', 'Api\TemplateSectionQuestionPositionController@index')->name('templates.sections.questions.positions.index');
Route::post('templates/{template}/sections/{ts}/questions/{tsq}/positions', 'Api\TemplateSectionQuestionPositionController@update')->name('templates.sections.questions.positions.update');
