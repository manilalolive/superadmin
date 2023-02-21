<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\CheckUserType;

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
Route::post('/login', [UserController::class, 'login']);


Route::middleware(['auth:api',CheckUserType::class])->group(function () {
	Route::get('/organizations',[OrganizationController::class,'index']);
	Route::post('/user',[UserController::class,'store']);
});

// routes for outside user
Route::middleware('auth:api')->group(function () {
	Route::post('/organization/store',[OrganizationController::class,'store']);
});
