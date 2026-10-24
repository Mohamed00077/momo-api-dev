<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\NoteController;





Route::post('/register',[AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/notes', [NoteController::class, 'index']);
Route::get('/notes/{note}', [NoteController::class, 'show']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile',[ProfileController::class, 'update']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::put('/notes/{note}', [NoteController::class, 'update']);
    Route::delete('/notes/{note}', [NoteController::class, 'destroy']);
});


