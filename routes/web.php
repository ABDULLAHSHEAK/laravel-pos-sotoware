<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::post('/user-registration',[UserController::class,'UserReg'])->name('User_reg');
Route::post('/user-login',[UserController::class,'UserLogin'])->name('User_login');
Route::post('/send-otp',[UserController::class, 'SendOTPCode'])->name('send-otp');
Route::post('/verify-otp',[UserController::class, 'VerifyOTP'])->name('verify-otp');


