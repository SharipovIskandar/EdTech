<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('subjects', SubjectController::class);
});