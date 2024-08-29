<?php

use App\Http\Controllers\Api\PegueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/citation', [PegueController::class, 'store'])->middleware('auth:sanctum');
