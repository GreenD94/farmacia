<?php

use App\Http\Controllers\chat\ChatsController;
use App\Http\Controllers\login\LoginsController;
use App\Http\Controllers\user\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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
Broadcast::routes(['middleware' => ['auth:sanctum']]);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () 
{
    Route::get  ('/user',[UsersController::class,'index'])->name('api.user.index');
    Route::get  ('/user/show',[UsersController::class,'show'])->name('api.user.show');
    Route::delete('/user', [UsersController::class,'destroy'])->name('api.user.destroy');
    Route::put('/user', [UsersController::class,'update'])->name('api.user.update');

});



// aqui
Route::post('/login', [LoginsController::class,'store'])->name('api.login.store');    
Route::post('/chat',[ChatsController::class,'store'])->name('api.chat.store');
Route::post('/user', [UsersController::class,'store'])->name('api.users.store');