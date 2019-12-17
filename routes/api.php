<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'users',
], function () {
    Route::post('/register', 'AuthController@register')->name('register');
    Route::post('/login', 'AuthController@login')->name('login');

    Route::group([
        'middleware' => 'auth.jwt'
    ], function () {
        Route::get('/logout', 'AuthController@logout')->name('logout');
        Route::post('/refresh', 'AuthController@refresh')->name('refresh');
        Route::post('/user', 'AuthController@user')->name('user');
    });
});

Route::group([
    'middleware' => 'auth.jwt',
    'prefix'     => 'todos',
], function () {
    Route::get('/', 'TodoController@index')->name('index.todo');
    Route::post('/', 'TodoController@store')->name('store.todo');
    Route::get('/{id}', 'TodoController@show')->name('show.todo');
    Route::put('/{id}', 'TodoController@update')->name('update.todo');
    Route::delete('/{id}', 'TodoController@destroy')->name('destroy.todo');
});
