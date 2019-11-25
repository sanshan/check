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

/*Route::group([
    'middleware' => 'api',
    'prefix'     => 'auth',
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('registration', 'AuthController@registration');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    //'middleware' => ['api', 'auth:api'],
    'middleware' => ['api'],
], function ($router) {

    Route::get('sections/datatable', 'Api\SectionController@dataTableIndex')->name('sections.index.datatable');
    Route::get('regions/datatable', 'Api\RegionController@dataTableIndex')->name('regions.index.datatable');


    Route::apiResource('templates.sections', 'Api\TemplateSectionController')->only(['index', 'store', 'update']);
    Route::delete('templates/{template}/sections', 'Api\TemplateSectionController@destroy')->name('templates.sections.destroy');

    Route::get('templates/{template}/sections/{ts}/questions', 'Api\TemplateSectionQuestionController@index')->name('templates.sections.questions.index');
    Route::post('templates/{template}/sections/{ts}/questions', 'Api\TemplateSectionQuestionController@store')->name('templates.sections.questions.store');
    Route::delete('templates/{template}/sections/{ts}/questions', 'Api\TemplateSectionQuestionController@destroy')->name('templates.sections.questions.destroy');

    Route::get('templates/{template}/sections/{ts}/questions/{tsq}/positions', 'Api\TemplateSectionQuestionPositionController@index')->name('templates.sections.questions.positions.index');
    Route::post('templates/{template}/sections/{ts}/questions/{tsq}/positions', 'Api\TemplateSectionQuestionPositionController@update')->name('templates.sections.questions.positions.update');



    Route::get('users/datatable', 'Api\UserController@dataTableIndex')->name('users.index.datatable');
    Route::get('typeofgasstations/datatable', 'Api\TypeOfGasStationController@dataTableIndex')->name('typeofgasstations.index.datatable');
    Route::get('positions/datatable', 'Api\PositionController@dataTableIndex')->name('positions.index.datatable');
    Route::get('typeofchecklists/datatable', 'Api\TypeOfChecklistController@dataTableIndex')->name('typeofchecklists.index.datatable');
    Route::get('gasstations/datatable', 'Api\GasStationController@dataTableIndex')->name('gasstations.index.datatable');

    Route::get('sections/{section}/questions/datatable', 'Api\QuestionController@dataTableIndex')->name('sections.questions.index.datatable');
    Route::get('templates/datatable', 'Api\TemplateController@dataTableIndex')->name('templates.index.datatable');
    Route::get('tasks/datatable', 'Api\TaskController@dataTableIndex')->name('tasks.index.datatable');

    Route::apiResources([
        'regions'            => 'Api\RegionController',
        'positions'          => 'Api\PositionController',
        'typeofgasstations'  => 'Api\TypeOfGasStationController',
        'typeofchecklists'   => 'Api\TypeOfChecklistController',
        'roles'              => 'Api\RoleController',
        'users'              => 'Api\UserController',
        'gasstations'        => 'Api\GasStationController',
        'sections'           => 'Api\SectionController',
        'sections.questions' => 'Api\QuestionController',
        'tasks'              => 'Api\TaskController',
        'templates'          => 'Api\TemplateController',
    ]);


});
