<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/candidates')->group(function(){
    Route::get('/all', [\App\Http\Controllers\CandidatesController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\CandidatesController::class, 'create']);
});
