<?php

Route::group(['namespace'=>'Bido\Dashboard\Http\Controllers', 'middleware'=>['web','auth', 'verified']], function ($router){
    $router->get('/home', 'DashboardController@home')->name('home');
});
