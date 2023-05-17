<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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

Route::get('/test', function () {
    return response()->json([
        'message' => 'Hello World'
    ], 200);
});

Route::get('/home', function () {
  return response()->json([
    'response' => 'Home page'
  ], 200);
});

Route::resource('users', UserController::class);
Route::resource('messages', MessageController::class);
