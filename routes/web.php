<?php

//use Illuminate\Support\Facades\Route;

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

    return view('index');
});

Route::get('/test', function (){
//    \Spatie\Permission\Models\Permission::create(['name'=>'teach']);
//    auth()->user()->givePermissionTo(\Bido\RolePermissions\Models\Permission::PERMISSION_TEACH);
//    return auth()->user()->Permissions;

      return auth()->user()->assignRole('teacher');
});
