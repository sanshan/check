<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('lists/positions', 'PositionController');
Route::get('lists/regions', 'RegionController');
Route::get('lists/typeofchecklists', 'TypeOfChecklistController');
Route::get('lists/typeofgasstations', 'TypeOfGasStationController');
Route::get('lists/users', 'UserController');
Route::get('lists/gasstations', 'GasStationController');
Route::get('audit/sections', 'SectionController');
Route::get('audit/sections/{section}/questions', 'QuestionController')->name('audit.questions');
Route::get('audit/templates', 'TemplateController');
Route::get('audit/tasks', 'TaskController');
