<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware('guest')->group(function(){
    Route::post('/register', [AccountController::class, 'store']);
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/sendotp', [AccountController::class, 'sendOtp']);
    Route::post('/resetpassword', [AccountController::class, 'resetPassword']);
});

Route::middleware('auth')->group(function(){
    Route::get('/postad', [AdvertController::class, 'index']);

    Route::get('/profile', [AccountController::class, 'profile']);
    Route::get('/profile/ads/active', [AccountController::class, 'active']);
    Route::get('/profile/ads/review', [AccountController::class, 'review']);
    Route::get('/profile/ads/closed', [AccountController::class, 'closed']);
    Route::get('/profile/feedback', [AccountController::class, 'feedback']);
    Route::get('/profile/opinions', [AccountController::class, 'opinions']);
    Route::get('/profile/messages', [AccountController::class, 'messages']);
    Route::get('/profile/premiumservices', [AccountController::class, 'premium']);
    Route::post('/logout', [AccountController::class, 'logout']);
});

Route::prefix('admin')->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('/login', [DashboardController::class, 'login'])->name('admin.login');
        Route::post('/signin', [DashboardController::class, 'signin']);
    });

    Route::middleware(['admin'])->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    });
});
