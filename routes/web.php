<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Authentication\RegisterController;
use App\Http\Controllers\User\Authentication\CurrentUserController;
use App\Http\Controllers\User\Authentication\LoginController;
use \App\Http\Controllers\User\Timeline\NormalPostController;
use \App\Http\Controllers\NormalUserController;
use \App\Http\Controllers\User\Authentication\CurrentDoctorController;
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

    Route::post('/login_doctor', [LoginController::class,'DoLogin']);

    //todo:get_current_user , logout
    Route::group(['middleware' => 'jwt.auth','guard'=>'web1'], function () {
        Route::get('/doctor',[CurrentDoctorController::class,'index']);
        Route::get('/doctor_logout',[CurrentDoctorController::class,'logout']);
    });
});

//TODO:Posts CRUD
Route::group(['prefix' => 'user-post'], function () {

    Route::resource('/posts', User\Timeline\PostController::class);
    Route::resource('/story', User\Timeline\PrivateSituations::class);
    Route::get('/getAllPostByUserId/{id}', [NormalPostController::class,'getAllPostByUserId']);

});

//TODO:Story CRUD
Route::group(['prefix' => 'user-story'], function () {
    Route::resource('/story', User\Timeline\PrivateSituations::class);
});

Route::group(['prefix' => 'user'], function () {
    Route::resource('/all-users', UserController::class);
    Route::get('/getUserByCharFromFName/{char}', [NormalUserController::class,'getUserByCharFromFName']);
    Route::get('/setDoctorFollow/{ids}', [NormalUserController::class,'setDoctorFollow']);
    Route::get('/getAllInfo', [NormalUserController::class,'getAllInfo']);
    Route::post('/info', [NormalUserController::class,'setInfo']);
    Route::get('/getPost/{ids}', [NormalUserController::class,'getOwnPost']);
});

Route::group(['prefix' => 'report'], function () {
    Route::resource('/all-reports', User\Report\TreatmentReportController::class);
});
