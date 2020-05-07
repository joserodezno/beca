<?php

Route::get('/', function () {
    return 'Home';
});

Route::get('/usuarios', 'UserController@index')
    ->name('users.index');

Route::get('/usuarios/{user}', 'UserController@show')
    ->where('user', '[0-9]+')
    ->name('users.show');

Route::get('/usuarios/nuevo', 'UserController@create')
    ->name('users.create');

Route::post('/usuarios', 'UserController@store');

Route::get('/saludo/{name}', 'WelcomeUserController@nonickname');

Route::get('/saludo/{name}/{nickname}', 'WelcomeUserController@welcome');

Route::get('/usuarios/{id}/edit', 'UserController@edit' )
    ->where('id', '[0-9]+');