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

Route::get('employee/list', ['as' => 'employee.index', 'uses' => 'EmployeesController@index']);
Route::get('employee/edit/{id}', ['as' => 'employee.edit', 'uses' => 'EmployeesController@edit']);
Route::post('employee/update/{id}', ['as' => 'employee.update', 'uses' => 'EmployeesController@update']);

Route::get('indicators/list', ['as' => 'indicator.index', 'uses' => 'IndicatorsController@index']);
Route::post('indicator/update/{id}', ['as' => 'indicator.update', 'uses' => 'IndicatorsController@update']);
Route::post('indicator/create', ['as' => 'indicator.create', 'uses' => 'IndicatorsController@store']);
Route::delete('indicator/delete/{id}', ['as' => 'indicator.delete', 'uses' => 'IndicatorsController@destroy']);