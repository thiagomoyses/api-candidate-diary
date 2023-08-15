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

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.verify')->prefix('auth')->group(function(){
        Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
        Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('auth.refresh');
});

Route::prefix('auth')->group(function(){
        Route::post('/signup', [\App\Http\Controllers\AuthController::class, 'signup'])->name('auth.signup');
        Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
});

Route::middleware('jwt.verify')->group(function() {
    Route::get('/dashboard', function() {
        return response()->json(['message' => 'Welcome to dashboard'], 200);
    });
});

Route::middleware('jwt.verify')->prefix('/candidates')->group(function(){
    Route::get('/all', [\App\Http\Controllers\CandidatesController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\CandidatesController::class, 'create']);
    Route::patch('/update/{id}', [\App\Http\Controllers\CandidatesController::class, 'update'])->where('id', '[0-9]+');
});


Route::middleware('jwt.verify')->prefix('/companies')->group(function(){
    Route::get('/all', [\App\Http\Controllers\CompaniesController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\CompaniesController::class, 'create']);
    Route::patch('/update/{id}', [\App\Http\Controllers\CompaniesController::class, 'update'])->where('id', '[0-9]+');
});

Route::middleware('jwt.verify')->prefix('/projects')->group(function() {
    Route::get('/all', [\App\Http\Controllers\ProjectsController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\ProjectsController::class, 'create']);
    Route::patch('/update/{job_reference}', [\App\Http\Controllers\ProjectsController::class, 'update'])->where('job_reference', '[A-Za-z0-9]{10}');
    Route::post('/delete/{job_reference}', [\App\Http\Controllers\ProjectsController::class, 'delete'])->where('job_reference', '[A-Za-z0-9]{10}');
});

Route::middleware('jwt.verify')->prefix('/diary')->group(function (){
    Route::get('/all', [\App\Http\Controllers\DiaryController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\DiaryController::class, 'create']);
    Route::patch('/update/{id}', [\App\Http\Controllers\DiaryController::class, 'update'])->where('id', '[0-9]+');
});