<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Authentication\RegisterController;
use App\Http\Controllers\User\Authentication\CurrentUserController;
use App\Http\Controllers\User\Authentication\LoginController;
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
    return view('welcome');
});

Route::group(['prefix'=>'api/auth','namespace'=>'User\Authentication'],function (){

    //    //todo:Login
        Route::post('/login', [LoginController::class,'DoLogin']);

        //todo:Register
        Route::post('/registerUser', [RegisterController::class,'DoRegister']);

        //todo:get_current_user , logout
        Route::group(['middleware' => 'jwt.auth'], function () {
            Route::get('/user',[CurrentUserController::class,'index']);
            Route::get('/logout',[CurrentUserController::class,'logout']);
        });
});

//TODO:Posts CRUD
Route::group(['prefix' => 'user-post'], function () {

    Route::resource('/posts', User\Timeline\PostController::class);

});
