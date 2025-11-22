<?php

use App\Http\Controllers\Api\BlogApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return ['message' => 'API OK'];
});


Route::get('/blogs',        [BlogApiController::class, 'index']);
Route::get('/blogs/{id}',   [BlogApiController::class, 'show']);
Route::post('/blogs',       [BlogApiController::class, 'store']);
Route::put('/blogs/{id}',   [BlogApiController::class, 'update']);
Route::patch('/blogs/{id}', [BlogApiController::class, 'update']);
Route::delete('/blogs/{id}', [BlogApiController::class, 'destroy']);
