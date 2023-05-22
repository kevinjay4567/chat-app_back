<?php

use App\Events\SendMessageEvent;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
  Route::get('/profile', [AuthController::class, 'profile']);
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/send', [MessageController::class, 'sendMessage']);
  Route::post('/contacts', [ContactController::class, 'addFriend']);
  Route::get('/friends', [ContactController::class, 'findUserFriends']);
  Route::post('/messages', [MessageController::class, 'findMessageWithFriend']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/messages/{id}', [MessageController::class, 'findMessageByUser']);
Route::get('/contacts', [ContactController::class, 'index']);
Route::resource('users', UserController::class);