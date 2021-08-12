<?php

use App\Http\Controllers\branch_office\BranchOfficesController;
use App\Http\Controllers\chat\ChatsController;
use App\Http\Controllers\companies\CompaniesController;
use App\Http\Controllers\login\AppLoginsController;
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
    //user
    Route::post('/user', [UsersController::class,'store'])->name('api.users.store');
    Route::get  ('/user/show',[UsersController::class,'show'])->name('api.user.show');
    Route::delete('/user', [UsersController::class,'destroy'])->name('api.user.destroy');
    Route::put('/user', [UsersController::class,'update'])->name('api.user.update');

    //branch office
    Route::get  ('/branch-office',[BranchOfficesController::class,'index'])->name('api.branch_office.index');
    Route::post('/branch-office', [BranchOfficesController::class,'store'])->name('api.branch_offices.store');
    Route::get  ('/branch-office/show',[BranchOfficesController::class,'show'])->name('api.branch_office.show');
    Route::delete('/branch-office', [BranchOfficesController::class,'destroy'])->name('api.branch_office.destroy');
    Route::put('/branch-office', [BranchOfficesController::class,'update'])->name('api.branch_office.update');

    //company
    Route::get  ('/company',[CompaniesController::class,'index'])->name('api.company.index');
    Route::post('/company', [CompaniesController::class,'store'])->name('api.companys.store');
    Route::get  ('/company/show',[CompaniesController::class,'show'])->name('api.company.show');
    Route::delete('/company', [CompaniesController::class,'destroy'])->name('api.company.destroy');
    Route::put('/company', [CompaniesController::class,'update'])->name('api.company.update');

});



// aqui
Route::post('/app-login', [AppLoginsController::class,'store'])->name('api.app_login.store');    
Route::post('/login', [LoginsController::class,'store'])->name('api.login.store');    
Route::post('/chat',[ChatsController::class,'store'])->name('api.chat.store');
Route::get  ('/user',[UsersController::class,'index'])->name('api.user.index');

