<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

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

Route::middleware('jwt.verify')->prefix('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('auth.refresh');
});

Route::prefix('auth')->group(function () {
    Route::post('/signup', [\App\Http\Controllers\AuthController::class, 'signup'])->name('auth.signup');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
});


/**
 * Candidates
 */
Route::middleware(['jwt.verify', 'ExtractClientIdFromToken'])->prefix('/candidates')->group(function () {
    Route::get('/all', [\App\Http\Controllers\CandidatesController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\CandidatesController::class, 'create']);
    Route::post('/delete/{id}', [\App\Http\Controllers\CandidatesController::class, 'delete'])->where('id', '[0-9]+');
    Route::patch('/update/{id}', [\App\Http\Controllers\CandidatesController::class, 'update'])->where('id', '[0-9]+');
});

/**
 * Companies
 */
Route::middleware(['jwt.verify', 'ExtractClientIdFromToken'])->prefix('/companies')->group(function () {
    Route::get('/all', [\App\Http\Controllers\CompaniesController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\CompaniesController::class, 'create']);
    Route::post('/delete/{id}', [\App\Http\Controllers\CompaniesController::class, 'delete'])->where('id', '[0-9]+');
    Route::patch('/update/{id}', [\App\Http\Controllers\CompaniesController::class, 'update'])->where('id', '[0-9]+');
});

/**
 * Projects
 */
Route::middleware(['jwt.verify', 'ExtractClientIdFromToken'])->prefix('/projects')->group(function () {
    Route::get('/all', [\App\Http\Controllers\ProjectsController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\ProjectsController::class, 'create']);
    Route::post('/delete/{job_reference}', [\App\Http\Controllers\ProjectsController::class, 'delete'])->where('job_reference', '[A-Za-z0-9]{10}');
    Route::patch('/update/{job_reference}', [\App\Http\Controllers\ProjectsController::class, 'update'])->where('job_reference', '[A-Za-z0-9]{10}');
});

/**
 * Diary
 */
Route::middleware(['jwt.verify', 'ExtractClientIdFromToken'])->prefix('/diary')->group(function () {
    Route::get('/all', [\App\Http\Controllers\DiaryController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\DiaryController::class, 'create']);
    Route::post('/delete/{id}', [\App\Http\Controllers\DiaryController::class, 'delete'])->where('id', '[0-9]+');
    Route::patch('/update/{id}', [\App\Http\Controllers\DiaryController::class, 'update'])->where('id', '[0-9]+');
});


/**
 * Feedback
 */

 Route::middleware(['jwt.verify', 'ExtractClientIdFromToken'])->prefix('/feedback')->group(function(){
    Route::post('/send/{id}', [\App\Http\Controllers\FeedbackController::class, 'sendForOne'])->where('id', '[0-9]+');
    Route::post('/send/all', [\App\Http\Controllers\FeedbackController::class, 'sendForAll']);
 });