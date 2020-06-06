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

Route::post('/user', 'UserController@update')->name('user.update');

Route::get('/project', 'ProjectController@index')->name('project.index');

Route::get('/project/create', 'ProjectController@create')->name('project.create');

Route::get('/project/{id}/edit', 'ProjectController@edit')->name('project.edit');

Route::patch('/project/{id}', 'ProjectController@update')->name('project.update');

Route::get('/project/{id}/', 'ProjectController@show')->name('project.show');

Route::delete('/project/{id}', 'ProjectController@destroy')->name('project.destroy');

Route::post('/project', 'ProjectController@store')->name('project.store');

Route::get('/ticket', 'TicketController@index')->name('ticket.index');

Route::get('/ticket/create', 'TicketController@create')->name('ticket.create');

Route::post('/ticket', 'TicketController@store')->name('ticket.store');

Route::get('/ticket/{id}/edit', 'TicketController@edit')->name('ticket.edit');

Route::patch('/ticket/{id}', 'TicketController@update')->name('ticket.update');

Route::get('/ticket/{id}/', 'TicketController@show')->name('ticket.show');