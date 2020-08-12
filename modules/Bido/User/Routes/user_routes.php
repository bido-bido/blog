<?php

Route::group(['namespace'=>'Bido\User\Http\Controllers', 'middleware'=>'web'], function ($router){
    Auth::routes(['verify'=>true]);
});