<?php

use App\Actions\SendOTP;
use App\Actions\PusherAuth;
use App\Actions\VerifyEmail;
use Illuminate\Http\Request;
use App\Actions\HandlePusher;
use App\Actions\HandlePayment;
use App\Actions\ResetPassword;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdvertController;

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

// Pusher presence webhook
Route::post('/pusher/webhook/presence', [HandlePusher::class, 'webhookHandler']);

// Pusher Private Channel Authentication
Route::post('/pusher/auth', [PusherAuth::class, 'handlePrivateChannelAuth']);

Route::post('/payment/webhook', [HandlePayment::class, 'handleWebhook']);

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

Route::get('/adverts', [AdvertController::class, 'index']);
Route::get('/categories', [AdvertController::class, 'categories']);
Route::get('/advert/{id}', [AdvertController::class, 'advert']);
Route::get('/reviews', [AdvertController::class, 'reviews']);


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [AuthController::class, 'index']);

    Route::get('/formdata', [AdvertController::class, 'categoriesWithProperties']);
    Route::post('/postad', [AdvertController::class, 'postAd']);
    Route::post('/addreview', [AdvertController::class, 'addReview']);


    Route::post('/logout', [AuthController::class, 'logout']);
});
