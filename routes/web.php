<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\Auth\CustomerResetPasswordController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Auth\AdminResetPasswordController;
use App\Http\Controllers\Auth\VendorForgotPasswordController;
use App\Http\Controllers\Auth\VendorResetPasswordController;
use App\Http\Controllers\AdminController;

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

Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "Cleared!";

}); 

Route::get('/', function () {
    return redirect('/login/customer');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/login/admin', [LoginController::class,'showAdminLoginForm'])->name('login.admin');
Route::get('/login/vendor', [LoginController::class,'showVendorLoginForm'])->name('login.vendor');
Route::get('/login/customer', [LoginController::class,'showCustomerLoginForm'])->name('login.customer');
Route::get('/register/admin', [RegisterController::class,'showAdminRegisterForm'])->name('register.admin');
Route::get('/register/vendor', [RegisterController::class,'showVendorRegisterForm'])->name('register.vendor');
Route::get('/register/customer', [RegisterController::class,'showCustomerRegisterForm'])->name('register.customer');

Route::post('/login/admin', [LoginController::class,'adminLogin']);
Route::post('/login/vendor', [LoginController::class,'vendorLogin']);
Route::post('/login/customer', [LoginController::class,'cutomerLogin']);
Route::post('/register/admin', [RegisterController::class,'createAdmin']);
Route::post('/register/vendor', [RegisterController::class,'createVendor']);
Route::post('/register/customer', [RegisterController::class,'createCustomer']);

Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin');
Route::view('/vendor', 'vendor');
Route::view('/customer', 'customer');


// Route::get('/logout', [LoginController::class,'logout']);


Route::prefix('customer')->group(function() {
   
    Route::post('/password/email',[CustomerForgotPasswordController::class,'sendResetLinkEmail'])->name('customer.password.email');
    Route::post('/password/reset', [CustomerResetPasswordController::class,'reset']);
    Route::get('/password/reset', [CustomerForgotPasswordController::class,'showLinkRequestForm'])->name('customer.password.request');                                     
    Route::get('/password/reset/{token}', [CustomerResetPasswordController::class,'showResetForm'])->name('customer.password.reset');

});


Route::prefix('admin')->group(function() {
   
    Route::post('/password/email',[AdminForgotPasswordController::class,'sendResetLinkEmail'])->name('admin.password.email');
    Route::post('/password/reset', [AdminResetPasswordController::class,'reset']);
    Route::get('/password/reset', [AdminForgotPasswordController::class,'showLinkRequestForm'])->name('admin.password.request');                                     
    Route::get('/password/reset/{token}', [AdminResetPasswordController::class,'showResetForm'])->name('admin.password.reset');
    
});

Route::prefix('vendor')->group(function() {
   
    Route::post('/password/email',[VendorForgotPasswordController::class,'sendResetLinkEmail'])->name('vendor.password.email');
    Route::post('/password/reset', [VendorResetPasswordController::class,'reset']);
    Route::get('/password/reset', [VendorForgotPasswordController::class,'showLinkRequestForm'])->name('vendor.password.request');                                     
    Route::get('/password/reset/{token}', [VendorResetPasswordController::class,'showResetForm'])->name('vendor.password.reset');
    
});


Route::get('customerList', [AdminController::class, 'index'])->name('admin.customerList');

Route::post('/employees/status',[AdminController::class, 'status']);