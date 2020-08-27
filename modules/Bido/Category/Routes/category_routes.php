<?php

Route::group(['namespace'=>'Bido\Category\Http\Controllers', 'middleware'=>['web', 'auth', 'verified']], function ($router){
    $router->resource('categories', 'CategoryController');
});