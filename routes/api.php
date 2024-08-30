<?php

use App\Http\Controllers\Api\PegueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/v1/citation', [PegueController::class, 'store'])
    ->middleware(['web', 'auth:sanctum']);
