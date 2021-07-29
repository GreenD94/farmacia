<?php

use App\Http\Controllers\chat\ChatsController;
use App\Http\Controllers\login\LoginsController;
use App\Http\Controllers\signup\SignupsController;
use App\Http\Controllers\user\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginsController::class,'index'])->name('login');
    Route::post('/login', [LoginsController::class,'store'])->name('api.login.store');
    Route::get('/signup', [SignupsController::class,'index'])->name('signup');
    Route::post('/users', [UsersController::class,'store'])->name('api.users.store');
});


Route::group(['middleware' => 'auth'], function () 
{
    Route::get('/chat', function () {
        $user=User::find( Auth::id());
        $routes =   [   
            'api_chat_store'         =>  route('api.chat.store'),
        ];
        $routes=json_encode($routes);           
        return view('chat.chat')->with('user', $user)->with('routes', $routes);
    })->name('chat');


  //  Route::post('/api/chat',[ChatsController::class,'store'])->name('api.chat.store');
});
