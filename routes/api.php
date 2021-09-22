<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SportController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\WageController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\NotificationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/forget', [AuthController::class, 'forget_password']);

Route::group(['middleware' => 'auth:api'], function () {
    //List...
    Route::get('/sports/list',[SportController::class, 'list'])->name('sports_list');
    Route::get('/teams/list/{sport_id}',[TeamController::class, 'list'])->name('teams_list');
    Route::get('/games/list/{sport_id}',[GameController::class, 'list'])->name('teams_list');
    Route::get('/contacts/list',[ContactController::class, 'list'])->name('contacts_list');
    Route::get('/feeds/list',[WageController::class, 'feeds'])->name('feed_list');

    //Detail...
    Route::get('/wages/detail/{wage_id}',[WageController::class, 'detail']);
    Route::get('/teams/detail/{team_id}',[TeamController::class, 'detail']);
    
    //Wage
    Route::post('/wages/create',[WageController::class, 'create']);
    Route::get('/wages/detail/{wage_id}',[WageController::class, 'detail']);
    Route::get('/wages/receive/{wage_id}',[WageController::class, 'receive']);
    Route::post('/wages/send/{wage_id}',[WageController::class, 'send']);
    Route::post('/wages/deny/{wage_id}',[WageController::class, 'deny']);
    Route::post('/wages/accept/{wage_id}',[WageController::class, 'accept']);
    Route::get('/wages/receive_list',[WageController::class, 'receive_list']);
    Route::get('/wages/send_list',[WageController::class, 'send_list']);
    Route::get('/wages/pending_list',[WageController::class, 'pending_list']);
    Route::get('/wages/complete_list',[WageController::class, 'complete_list']);
    
    Route::get('/wages/result/{wage_id}',[WageController::class, 'result']);
    Route::get('/wages/recent',[WageController::class, 'recent_list']);
    //Coometn...

    Route::post('/wages/comment/create',[WageController::class, 'create_comment']);
    Route::post('/wages/comment/get/{comment_id}',[WageController::class, 'get_comment']);
    Route::post('/wages/comment/update',[WageController::class, 'update_comment']);
    //User List
    Route::get('/contacts/list',[ContactController::class, 'list']);
    Route::get('/contacts/search',[ContactController::class, 'find_user']);
    Route::get('/contacts/detail/{user_id}',[ContactController::class, 'detail']);
    Route::get('/contacts/user_list',[ContactController::class, 'user_list']);
    Route::post('/contacts/enable_contact/{user_id}',[ContactController::class, 'enable_contact']);
    Route::get('/contacts/get',[ContactController::class, 'get_friends']);

    Route::post('/notifications/confirm',[NotificationController::class, 'confirm']);
    Route::post('/notifications/get',[NotificationController::class, 'get_notification']);
});