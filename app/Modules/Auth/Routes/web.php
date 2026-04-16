<?php

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function(){
    return inertia('Auth/Login');
})->name('login');

Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);
