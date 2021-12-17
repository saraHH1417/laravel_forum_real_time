<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyController;
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


Route::apiResource('/questions' , QuestionController::class);
Route::get('/two' , [QuestionController::class , 'indexTwo']);
Route::get('/questionsRepository' , [QuestionController::class , 'indexThreeWithRepository']);
Route::get('/questionsRepositoryResource' , [QuestionController::class , 'indexFourWithRepositoryForResource']);
Route::apiResource('/categories' , CategoryController::class);

Route::apiResource('/{question}/reply' , ReplyController::class);

Route::post('/reply/{reply}/like' , [LikeController::class , 'likeIt']);
Route::delete('/reply/{reply}/like' , [LikeController::class , 'unLikeIt']);

Route::post('/notifications' , [NotificationController::class , 'index']);
Route::post('/markAsRead' , [NotificationController::class, 'markAsRead']);
//Route::post('notifications' , function (){
//    return [
//        'read' => auth()->user()->readNotifications(),
//        'unread' => auth()->user()->unReadNotifications()
//    ];
//});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
