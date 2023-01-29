<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('check-otp-code-login', [LoginController::class, 'verificationOTPLogin']);

Route::name('api.')->group(function() {
    Route::get('user/verification', [LoginController::class, 'verification'])->name('verification');
    
    Route::get('get-question-learn', [QuestionController::class, 'questionSubLearn']);
    Route::get('get-news', [NewsController::class, 'newsList']);
    Route::get('get-slide-news', [NewsController::class, 'slideNewsList']);
    
    Route::post('update-user/{user_id}', [UserController::class, 'updateDataUserById']);

    Route::get('get-member-learn', [MemberController::class, 'getMemberLearn']);
    Route::get('get-member-sub-learn', [MemberController::class, 'getMemberSubLearn']);
    Route::get('get-member-learn/{user_id}', [MemberController::class, 'getMemberLearnByUser']);
    Route::get('get-member-sub-learn/{user_id}/{learn_id}', [MemberController::class, 'getMemberSubLearnByUser']);

    Route::post('update-member-learn/{user_id}/{learn_id}', [MemberController::class, 'updateMemberLearn']);

    Route::post('update-member-sub-learn/{user_id}/{sub_learn_id}', [MemberController::class, 'updateMemberSubLearn']);

    Route::post('sublearn-active/{user_id}/{sub_learn_id}', [MemberController::class, 'updateStatusMemberSubLearn']);

    Route::post('generate-member-sub-learn', [MemberController::class, 'generateMemberSubLearn']);

    Route::post('detail-user', [UserController::class, 'detailUser']);
    Route::post('request-reset-password', [UserController::class, 'requestResetPassword'])->name('request-reset-password');

    Route::post('feedback-store', [FeedbackController::class, 'feedbackStore'])->name('feedback.store');
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        // Route::get('get-news', [NewsController::class, 'newsList']);
        Route::post('update-user', [UserController::class, 'updateDataUser']);
        Route::post('change-password', [UserController::class, 'changePassword']);
    });

});
