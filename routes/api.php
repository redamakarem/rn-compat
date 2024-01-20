<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GoogleSignIn;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CriteriaController;
use App\Http\Controllers\API\CandidatesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->group(function () {
    // Your routes go here
    Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');
    // Candidates
    Route::get('/candidates', [CandidatesController::class, 'index'])->name('candidates');
    Route::post('/candidates', [CandidatesController::class, 'store'])->name('candidates.store');


    // Criteria

    Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria');
    Route::post('/criteria', [CriteriaController::class, 'store'])->name('criteria.store');
    
    
});





Route::post('register', [AuthController::class, 'createUser'])->name('register');
Route::post('login', [AuthController::class, 'loginUser'])->name('login');


Route::get('auth/google', [GoogleSignIn::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleSignIn::class, 'handleGoogleCallback']);
Route::post('auth/google/token', [GoogleSignIn::class, 'GoogleLoginWithToken']);


// To test


