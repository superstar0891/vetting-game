<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;

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
    return redirect("/login");
});
// Route::redirect('/prefix/change', '/login', 301);
Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    // INDEX - shows all records
    Route::get('/redirectTo', [HomeController::class,'redirectTo'])->name('redirectTo');
    Route::get('/profile', [ProfileController::class,'index']);
    Route::post('/profile/detail', [ProfileController::class,'detail']);
    Route::get('/profile/edit/{user_id}', [ProfileController::class,'edit']);
    Route::get('/profile/show/{user_id}', [ProfileController::class,'index']);
    Route::post('/profile/update', [ProfileController::class,'update']);

    Route::group(['prefix' => 'admin'],function(){
        Route::get('/change', [ProfileController::class,'change_admin'])->middleware('admin-only');
        Route::get('/profile', [ProfileController::class,'admin'])->middleware('admin-only');
        Route::post('/change', [ProfileController::class,'admin_password'])->name('admin_password')->middleware('admin-only');
        Route::post('/updateProfile', [ProfileController::class,'admin_update'])->middleware('admin-only');

        Route::post('/users/edit',[DashboardController::class,'edit'])->middleware('admin-only');
        Route::post('/users/update',[DashboardController::class,'update'])->middleware('admin-only');
        Route::post('/users/add',[DashboardController::class,'add'])->middleware('admin-only');
        Route::get('/users/delete/{user_id}',[DashboardController::class,'delete'])->middleware('admin-only');
        Route::get('/users/{user_id}', [ProifleController::class,'admin'])->middleware('admin-only');
        Route::get('/dashboard', [DashboardController::class,'index'])->name('admin_dashboard')->middleware('admin-only');
        Route::get('/users', [DashboardController::class,'users'])->name('admin_user')->middleware('admin-only');
        Route::get('/payments', [PaymentController::class,'index'])->name('admin_payment')->middleware('admin-only');
        Route::get('/bettings/{sport_id}', [GameController::class,'index'])->name('admin_betting')->middleware('admin-only');
        Route::post('/bettings/{sport_id}', [GameController::class,'load'])->middleware('admin-only');
        Route::post('/games/getOdds', [GameController::class,'getOdds'])->middleware('admin-only');
        Route::post('/games/updateOdds', [GameController::class,'updateOdds'])->middleware('admin-only');
        Route::get('/users/{user_id}', [DashboardController::class,'user_show'])->middleware('admin-only');
    });

    Route::group(['prefix' => 'user'],function(){
        Route::get('/dashboard', [UserController::class,'dashboard'])->middleware('user-only');
        Route::get('/change', [ProfileController::class,'change_user'])->middleware('user-only');
        Route::post('/change', [ProfileController::class,'user_password'])->name('user_password')->middleware('user-only');
        //Profile.............
        Route::get('/profile', [ProfileController::class,'user'])->middleware('user-only');
        Route::post('/updateProfile', [ProfileController::class,'user_update'])->middleware('user-only');

        Route::get('/users/{user_id}', [ProifleController::class,'admin'])->middleware('user-only');
        //Verify..............

        Route::get('/payment/verify', [UserController::class,'payment_verify'])->name('verify')->middleware('user-only');
        Route::post('/payment/checkout', [UserController::class,'checkout'])->name('checkout')->middleware('user-only');
        Route::get('/payment/checkout', [UserController::class,'verify_status'])->name('verify_status')->middleware('user-only');

        //Deposit.............
        Route::get('/payment/deposit', [UserController::class,'payment_deposit'])->name('deposit')->middleware('user-only');
        Route::post('/payment/pay', [UserController::class,'deposit'])->name('pay')->middleware('user-only');
        Route::get('/payment/pay', [UserController::class,'deposit_status'])->name('deposit_status')->middleware('user-only');
        Route::get('/payment/confirm', [UserController::class,'deposit_confirm'])->name('deposit_confirm')->middleware('user-only');

        //Withdraw............
        Route::get('/payment/withdraw', [UserController::class,'payment_withdraw'])->name('withdraw')->middleware('user-only');
        Route::post('/payment/withdraw', [UserController::class,'withdraw'])->middleware('user-only');
        Route::get('/payment/withdraw_confirm', [UserController::class,'withdraw_confirm'])->name('withdraw_confirm')->middleware('user-only');

        Route::get('/transaction', [UserController::class,'transaction'])->middleware('user-only');
        Route::get('/history', [UserController::class,'history'])->middleware('user-only');


        Route::get('/friend', [UserController::class,'friend'])->middleware('user-only');
        Route::get('/transaction', [UserController::class,'transaction'])->middleware('user-only');
    });
});
