<?php

use App\Http\Controllers\address\OfficeAddressController;
use App\Http\Controllers\address\UserAddressController;
use App\Http\Controllers\branch_office\BranchOfficesController;
use App\Http\Controllers\category\CategoriesController;
use App\Http\Controllers\category_subscription\CategorySubscriptionsController;
use App\Http\Controllers\chat\ChatsController;
use App\Http\Controllers\color\OfficeColorController;
use App\Http\Controllers\color_tag\OfficeColorRolesController;
use App\Http\Controllers\company\CompaniesController;
use App\Http\Controllers\currency\CurrenciesController;
use App\Http\Controllers\image\OfficeImageController;
use App\Http\Controllers\image\ProductImageController;
use App\Http\Controllers\image\UserImageController;
use App\Http\Controllers\image_tag\OfficeImageRolesController;
use App\Http\Controllers\image_tag\ProductImageRolesController;
use App\Http\Controllers\image_tag\UserImageRolesController;
use App\Http\Controllers\login\AppLoginsController;
use App\Http\Controllers\login\LoginsController;
use App\Http\Controllers\office_subscription\OfficeSubscriptionsController;
use App\Http\Controllers\product\ProductsController;
use App\Http\Controllers\role\RolesController;
use App\Http\Controllers\role_subscription\RolesubscriptionsController;
use App\Http\Controllers\user\UsersController;
use App\Models\ProductDetail;
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

    //user address 
    Route::get  ('/user-address',[UserAddressController::class,'index'])->name('api.user_address.index');
    Route::post('/user-address', [UserAddressController::class,'store'])->name('api.user_address.store');
    Route::get  ('/user-address/show',[UserAddressController::class,'show'])->name('api.user_address.show');
    Route::delete('/user-address', [UserAddressController::class,'destroy'])->name('api.user_address.destroy');
    Route::put('/user-address', [UserAddressController::class,'update'])->name('api.user_address.update');

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

    //office address 
    Route::get  ('/office-address',[OfficeAddressController::class,'index'])->name('api.office_address.index');
    Route::post('/office-address', [OfficeAddressController::class,'store'])->name('api.office_address.store');
    Route::get  ('/office-address/show',[OfficeAddressController::class,'show'])->name('api.office_address.show');
    Route::delete('/office-address', [OfficeAddressController::class,'destroy'])->name('api.office_address.destroy');
    Route::put('/office-address', [OfficeAddressController::class,'update'])->name('api.office_address.update');

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

    //product
    Route::get  ('/product',[ProductsController::class,'index'])->name('api.product.index');
    Route::post('/product', [ProductsController::class,'store'])->name('api.product.store');
    Route::get  ('/product/show',[ProductsController::class,'show'])->name('api.product.show');
    Route::delete('/product', [ProductsController::class,'destroy'])->name('api.product.destroy');
    Route::put('/product', [ProductsController::class,'update'])->name('api.product.update');

    //product category
    Route::get  ('/product-detail',[ProductDetail::class,'index'])->name('api.product_detail.index');
    Route::post('/product-detail', [ProductDetail::class,'store'])->name('api.product_detail.store');
    Route::get  ('/product-detail/show',[ProductDetail::class,'show'])->name('api.product_detail.show');
    Route::delete('/product-detail', [ProductDetail::class,'destroy'])->name('api.product_detail.destroy');
    Route::put('/product-detail', [ProductDetail::class,'update'])->name('api.product_detail.update');

    
    //product image role
    Route::get  ('/product-image-role',[ProductImageRolesController::class,'index'])->name('api.product_image_role.index');
    Route::post('/product-image-role', [ProductImageRolesController::class,'store'])->name('api.product_image_role.store');
    Route::get  ('/product-image-role/show',[ProductImageRolesController::class,'show'])->name('api.product_image_role.show');
    Route::delete('/product-image-role', [ProductImageRolesController::class,'destroy'])->name('api.product_image_role.destroy');
    Route::put('/product-image-role', [ProductImageRolesController::class,'update'])->name('api.product_image_role.update');

    //product image 
    Route::get  ('/product-image',[ProductImageController::class,'index'])->name('api.product_image.index');
    Route::post('/product-image', [ProductImageController::class,'store'])->name('api.product_image.store');
    Route::get  ('/product-image/show',[ProductImageController::class,'show'])->name('api.product_image.show');
    Route::delete('/product-image', [ProductImageController::class,'destroy'])->name('api.product_image.destroy');
    Route::put('/product-image', [ProductImageController::class,'update'])->name('api.product_image.update');   

    
    //product category
    Route::get  ('/product-category',[CategoriesController::class,'index'])->name('api.product_category.index');
    Route::post('/product-category', [CategoriesController::class,'store'])->name('api.product_category.store');
    Route::get  ('/product-category/show',[CategoriesController::class,'show'])->name('api.product_category.show');
    Route::delete('/product-category', [CategoriesController::class,'destroy'])->name('api.product_category.destroy');
    Route::put('/product-category', [CategoriesController::class,'update'])->name('api.product_category.update');

    //product category subscription
    Route::get  ('/product-category-subscription',[CategorySubscriptionsController::class,'index'])->name('api.product_category_subscription.index');
    Route::post('/product-category-subscription', [CategorySubscriptionsController::class,'store'])->name('api.product_category_subscription.store');
    Route::get  ('/product-category-subscription/show',[CategorySubscriptionsController::class,'show'])->name('api.product_category_subscription.show');
    Route::delete('/product-category-subscription', [CategorySubscriptionsController::class,'destroy'])->name('api.product_category_subscription.destroy');
    Route::put('/product-category-subscription', [CategorySubscriptionsController::class,'update'])->name('api.product_category_subscription.update');



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


