<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuestionTypeController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\TopicController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('topics', TopicController::class);
    Route::apiResource('question-types', QuestionTypeController::class);
});