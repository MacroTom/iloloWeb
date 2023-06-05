<?php

use App\Actions\ResetPassword;
use App\Actions\SendOTP;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;

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

Route::get('/migrate', function(){
    Artisan::call('migrate:fresh --force');
    dd('Migrate command ran');
});

Route::middleware('guest')->group(function(){
    Route::post('/register', [AccountController::class, 'store']);
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/sendotp', [SendOTP::class, 'handle']);
    Route::post('/resetpassword', [ResetPassword::class, 'handle']);
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

        Route::get('/users', [DashboardController::class, 'users']);
        Route::get('/user/{id}', [DashboardController::class, 'user']);

        Route::post('/user/{id}/promote', [DashboardController::class, 'promote']);
        Route::post('/user/{id}/demote', [DashboardController::class, 'demote']);
        Route::post('/user/{id}/enable', [DashboardController::class, 'enable']);
        Route::post('/user/{id}/disable', [DashboardController::class, 'disable']);

        Route::get('/admins', [DashboardController::class, 'admins']);

        Route::get('/adverts', [DashboardController::class, 'adverts']);


        Route::get('/properties', [DashboardController::class, 'properties']);
        Route::post('/addproperty', [DashboardController::class, 'addProperty']);
        Route::post('/updateproperty/{id}', [DashboardController::class, 'updateProperty']);
        Route::post('/deleteproperty/{id}', [DashboardController::class, 'deleteProperty']);
    });
});
