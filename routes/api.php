<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

Route::post('/login', function(Request $request){
    $credentials = $request->only(['email', 'password']);

    if(!$token = auth('api')->attempt($credentials)){
        abort(401);
    }

    return response()->json([
        'data' => [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]
    ]);
});

Route::prefix('/candidates')->group(function(){
    Route::get('/all', [\App\Http\Controllers\CandidatesController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\CandidatesController::class, 'create']);
    Route::patch('/update/{id}', [\App\Http\Controllers\CandidatesController::class, 'update'])->where('id', '[0-9]+');
});


Route::prefix('/companies')->group(function(){
    Route::get('/all', [\App\Http\Controllers\CompaniesController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\CompaniesController::class, 'create']);
    Route::patch('/update/{id}', [\App\Http\Controllers\CompaniesController::class, 'update'])->where('id', '[0-9]+');
});

Route::prefix('/projects')->group(function() {
    Route::get('/all', [\App\Http\Controllers\ProjectsController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\ProjectsController::class, 'create']);
    Route::patch('/update/{job_reference}', [\App\Http\Controllers\ProjectsController::class, 'update'])->where('job_reference', '[A-Za-z0-9]{10}');
    Route::post('/delete/{job_reference}', [\App\Http\Controllers\ProjectsController::class, 'delete'])->where('job_reference', '[A-Za-z0-9]{10}');
});

Route::prefix('/diary')->group(function (){
    Route::get('/all', [\App\Http\Controllers\DiaryController::class, 'index']);
    Route::post('/create', [\App\Http\Controllers\DiaryController::class, 'create']);
    Route::patch('/update/{id}', [\App\Http\Controllers\DiaryController::class, 'update'])->where('id', '[0-9]+');
});