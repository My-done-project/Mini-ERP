<?php

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class,'loginApi']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class,'logoutApi']);
