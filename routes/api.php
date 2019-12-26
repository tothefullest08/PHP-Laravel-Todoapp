<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'users',
], function () {
    Route::post('/register', 'UserController@register')->name('register');
    Route::post('/refresh', 'UserController@refresh')->name('refresh');
    Route::post('/current_user', 'UserController@getCurrentUser')->name('currentUser');
});

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('/', 'AuthController@login')->name('login');
    Route::get('/', 'AuthController@logout')->name('logout');
});


Route::group([
    'middleware' => 'auth.jwt',
    'prefix'     => 'todos',
], function () {
    Route::get('/', 'TodoController@index')->name('index.todo');
    Route::post('/', 'TodoController@create')->name('create.todo');
    Route::get('/{id}', 'TodoController@show')->name('show.todo');
    Route::put('/{id}', 'TodoController@update')->name('update.todo');
    Route::delete('/{id}', 'TodoController@destroy')->name('destroy.todo');
});
