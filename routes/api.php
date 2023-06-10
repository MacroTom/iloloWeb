<?php

use App\Actions\ResetPassword;
use App\Actions\SendOTP;
use App\Actions\VerifyEmail;
use App\Http\Controllers\Api\AdvertController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/sendotp', [SendOTP::class, 'handle']);
Route::post('/verifyemail', [VerifyEmail::class, 'handle']);
Route::post('/resetpassword', [ResetPassword::class, 'handle']);

Route::get('/location', function(){
    return response([
        'message' => 'Data retrieved!',
        'data' => getStates()
    ]);
});


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [AuthController::class, 'index']);

    Route::get('/adverts', [AdvertController::class, 'index']);

    Route::get('/categories', [AdvertController::class, 'categories']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
