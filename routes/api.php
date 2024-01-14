<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GoogleSignIn;
use App\Http\Controllers\API\AuthController;

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


Route::get('/', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logoutUser'])->name('logout');


Route::post('register', [AuthController::class, 'createUser'])->name('register');
Route::post('login', [AuthController::class, 'loginUser'])->name('login');


Route::get('auth/google', [GoogleSignIn::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleSignIn::class, 'handleGoogleCallback']);
Route::post('auth/google/token', [GoogleSignIn::class, 'GoogleLoginWithToken']);
