<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\AuthController;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/register', AuthController::class);
Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

Route::apiResource('/businesses', 'App\Http\Controllers\Api\BusinessController')->middleware('auth:api');

// Incase anything goes wrong
Route::fallback(function(){
    return response(['error' => 'Resource not found!'], 404);
})->name('fallback');