<?php

use App\Http\Controllers\chat\ChatsController;
use App\Http\Controllers\login\LoginsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



// aqui
Route::post('/login', [LoginsController::class,'store'])->name('api.login.store');    
Route::post('/chat',[ChatsController::class,'store'])->name('api.chat.store');