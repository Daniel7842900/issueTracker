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

Route::get('/ticket', 'TicketController@index')->name('ticket.index')->middleware('auth');

Route::get('/ticket/create', 'TicketController@create')->name('ticket.create')->middleware('auth');

Route::post('/ticket', 'TicketController@store')->name('ticket.store')->middleware('auth');

Route::get('/ticket/{id}/edit', 'TicketController@edit')->name('ticket.edit')->middleware('auth');

Route::patch('/ticket/{id}', 'TicketController@update')->name('ticket.update')->middleware('auth');

Route::get('/ticket/{id}', 'TicketController@show')->name('ticket.show')->middleware('auth');

Route::delete('/ticket/{id}', 'TicketController@destroy')->name('ticket.destroy')->middleware('auth');

Route::get('/comment/{id}', 'CommentController@index')->name('comment.index');

Route::post('/comment/{id}', 'CommentController@store')->name('comment.store');

Route::get('/attachment', 'AttachmentController@index')->name('attachment.index');

Route::post('/attachment/{id}', 'AttachmentController@store')->name('attachment.store');

Route::get('/attachment/{id}', 'AttachmentController@show')->name('attachment.show')->middleware('auth');

Route::get('/attachment/{id}/edit', 'AttachmentController@edit')->name('attachment.edit')->middleware('auth');

Route::patch('/attachment/{id}', 'AttachmentController@update')->name('attachment.update')->middleware('auth');