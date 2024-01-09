<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GoogleSignIn;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'createUser'])->name('register');
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'loginUser'])->name('login');


Route::get('auth/google', [GoogleSignIn::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleSignIn::class, 'handleGoogleCallback']);
