<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', 'UserController@index')->name('user.index');

// Route::post('/user', 'UserController@update')->name('user.update');

//Route::resource('user', 'UserController');

Route::post('/user', 'UserController@update')->name('user.update');

Route::get('/project', 'ProjectController@index')->name('project.index');

Route::get('/project/create', 'ProjectController@create')->name('project.create');

Route::get('/project/{id}/edit', 'ProjectController@edit')->name('project.edit');

Route::patch('/project/{id}', 'ProjectController@update')->name('project.update');

Route::get('/project/{id}/show', 'ProjectController@show')->name('project.show');

Route::delete('/project/{id}', 'ProjectController@destroy')->name('project.destroy');

Route::post('/project', 'ProjectController@store')->name('project.store');