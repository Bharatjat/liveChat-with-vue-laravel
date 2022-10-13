<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers
use App\Http\Controllers\ChatController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// making new register
Route::post('/register', [AuthController::class, 'register']);

// handel login 
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function(){

    // for logout
    Route::get('/logout', [AuthController::class, 'logout']);

    // for fetching all chat
    Route::post('/messages', [ChatController::class, 'allChat']);

    // for storing message
    Route::post('/messageStore', [ChatController::class, 'messageStore']);
});