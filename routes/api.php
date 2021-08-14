<?php

use App\Http\Controllers\branch_office\BranchOfficesController;
use App\Http\Controllers\chat\ChatsController;
use App\Http\Controllers\color\OfficeColorController;
use App\Http\Controllers\color_tag\OfficeColorRolesController;
use App\Http\Controllers\companies\CompaniesController;
use App\Http\Controllers\currency\CurrenciesController;
use App\Http\Controllers\image\OfficeImageController;
use App\Http\Controllers\image\UserImageController;
use App\Http\Controllers\image_tag\OfficeImageRolesController;
use App\Http\Controllers\image_tag\UserImageRolesController;
use App\Http\Controllers\login\AppLoginsController;
use App\Http\Controllers\login\LoginsController;
use App\Http\Controllers\office_subscription\OfficeSubscriptionsController;
use App\Http\Controllers\role\RolesController;
use App\Http\Controllers\role_subscription\RolesubscriptionsController;
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
    Route::get  ('/user',[UsersController::class,'index'])->name('api.user.index');
    Route::get  ('/user/show',[UsersController::class,'show'])->name('api.user.show');
    Route::delete('/user', [UsersController::class,'destroy'])->name('api.user.destroy');
    Route::put('/user', [UsersController::class,'update'])->name('api.user.update');

    //roles 
    Route::get  ('/role',[RolesController::class,'index'])->name('api.role.index');
    Route::post('/role', [RolesController::class,'store'])->name('api.role.store');
    Route::get  ('/role/show',[RolesController::class,'show'])->name('api.role.show');
    Route::delete('/role', [RolesController::class,'destroy'])->name('api.role.destroy');
    Route::put('/role', [RolesController::class,'update'])->name('api.role.update');

    //user image role
    Route::get  ('/user-image-role',[UserImageRolesController::class,'index'])->name('api.user_image_role.index');
    Route::post('/user-image-role', [UserImageRolesController::class,'store'])->name('api.user_image_role.store');
    Route::get  ('/user-image-role/show',[UserImageRolesController::class,'show'])->name('api.user_image_role.show');
    Route::delete('/user-image-role', [UserImageRolesController::class,'destroy'])->name('api.user_image_role.destroy');
    Route::put('/user-image-role', [UserImageRolesController::class,'update'])->name('api.user_image_role.update');

    //user image 
    Route::get  ('/user-image',[UserImageController::class,'index'])->name('api.user_image.index');
    Route::post('/user-image', [UserImageController::class,'store'])->name('api.user_image.store');
    Route::get  ('/user-image/show',[UserImageController::class,'show'])->name('api.user_image.show');
    Route::delete('/user-image', [UserImageController::class,'destroy'])->name('api.user_image.destroy');
    Route::put('/user-image', [UserImageController::class,'update'])->name('api.user_image.update');

    //role subscription     
    Route::post('/role-subscription', [RolesubscriptionsController::class,'store'])->name('api.role_subscription.store'); 
    Route::delete('/role-subscription', [RolesubscriptionsController::class,'destroy'])->name('api.role_subscription.destroy');
    Route::put('/role-subscription', [RolesubscriptionsController::class,'update'])->name('api.role_subscription.update');

    //office subscription     
    Route::post('/office-subscription', [OfficeSubscriptionsController::class,'store'])->name('api.office_subscription.store'); 
    Route::delete('/office-subscription', [OfficeSubscriptionsController::class,'destroy'])->name('api.office_subscription.destroy');
    Route::put('/office-subscription', [OfficeSubscriptionsController::class,'update'])->name('api.office_subscription.update');

    //branch office
    Route::get  ('/branch-office',[BranchOfficesController::class,'index'])->name('api.branch_office.index');
    Route::post('/branch-office', [BranchOfficesController::class,'store'])->name('api.branch_office.store');
    Route::get  ('/branch-office/show',[BranchOfficesController::class,'show'])->name('api.branch_office.show');
    Route::delete('/branch-office', [BranchOfficesController::class,'destroy'])->name('api.branch_office.destroy');
    Route::put('/branch-office', [BranchOfficesController::class,'update'])->name('api.branch_office.update');

    //branch office image role
    Route::get  ('/office-image-role',[OfficeImageRolesController::class,'index'])->name('api.office_image_role.index');
    Route::post('/office-image-role', [OfficeImageRolesController::class,'store'])->name('api.office_image_role.store');
    Route::get  ('/office-image-role/show',[OfficeImageRolesController::class,'show'])->name('api.office_image_role.show');
    Route::delete('/office-image-role', [OfficeImageRolesController::class,'destroy'])->name('api.office_image_role.destroy');
    Route::put('/office-image-role', [OfficeImageRolesController::class,'update'])->name('api.office_image_role.update');

    //branch office image 
    Route::get  ('/office-image',[OfficeImageController::class,'index'])->name('api.office_image.index');
    Route::post('/office-image', [OfficeImageController::class,'store'])->name('api.office_image.store');
    Route::get  ('/office-image/show',[OfficeImageController::class,'show'])->name('api.office_image.show');
    Route::delete('/office-image', [OfficeImageController::class,'destroy'])->name('api.office_image.destroy');
    Route::put('/office-image', [OfficeImageController::class,'update'])->name('api.office_image.update');

    //branch office color role
    Route::get  ('/office-color-role',[OfficeColorRolesController::class,'index'])->name('api.office_color_role.index');
    Route::post('/office-color-role', [OfficeColorRolesController::class,'store'])->name('api.office_color_role.store');
    Route::get  ('/office-color-role/show',[OfficeColorRolesController::class,'show'])->name('api.office_color_role.show');
    Route::delete('/office-color-role', [OfficeColorRolesController::class,'destroy'])->name('api.office_color_role.destroy');
    Route::put('/office-color-role', [OfficeColorRolesController::class,'update'])->name('api.office_color_role.update');

    //currency 
    Route::get  ('/currency',[CurrenciesController::class,'index'])->name('api.currency.index');
    Route::post('/currency', [CurrenciesController::class,'store'])->name('api.currency.store');
    Route::get  ('/currency/show',[CurrenciesController::class,'show'])->name('api.currency.show');
    Route::delete('/currency', [CurrenciesController::class,'destroy'])->name('api.currency.destroy');
    Route::put('/currency', [CurrenciesController::class,'update'])->name('api.currency.update');

    //branch office color 
    Route::get  ('/office-color',[OfficeColorController::class,'index'])->name('api.office_color.index');
    Route::post('/office-color', [OfficeColorController::class,'store'])->name('api.office_color.store');
    Route::get  ('/office-color/show',[OfficeColorController::class,'show'])->name('api.office_color.show');
    Route::delete('/office-color', [OfficeColorController::class,'destroy'])->name('api.office_color.destroy');
    Route::put('/office-color', [OfficeColorController::class,'update'])->name('api.office_color.update');

    //company
    Route::get  ('/company',[CompaniesController::class,'index'])->name('api.company.index');
    Route::post('/company', [CompaniesController::class,'store'])->name('api.company.store');
    Route::get  ('/company/show',[CompaniesController::class,'show'])->name('api.company.show');
    Route::delete('/company', [CompaniesController::class,'destroy'])->name('api.company.destroy');
    Route::put('/company', [CompaniesController::class,'update'])->name('api.company.update');

});



// aqui
Route::post('/app-login', [AppLoginsController::class,'store'])->name('api.app_login.store');    
Route::post('/login', [LoginsController::class,'store'])->name('api.login.store');    
Route::post('/chat',[ChatsController::class,'store'])->name('api.chat.store');
Route::post('/user', [UsersController::class,'store'])->name('api.user.store');


