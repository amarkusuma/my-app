<?php

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

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\LearnsController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SubLearnController;
use App\Http\Controllers\SubSoalController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => ['get.menu']], function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return view('dashboard.homepage');
        }
        return view('auth.login');
    });

    Route::group(['middleware' => ['role:user']], function () {
        Route::get('/404', function () {        return view('dashboard.404'); });
        Route::get('/500', function () {        return view('dashboard.500'); });
        Route::prefix('buttons')->group(function () {
            Route::get('/buttons', function(){          return view('dashboard.buttons.buttons'); });
            Route::get('/button-group', function(){     return view('dashboard.buttons.button-group'); });
            Route::get('/dropdowns', function(){        return view('dashboard.buttons.dropdowns'); });
            Route::get('/brand-buttons', function(){    return view('dashboard.buttons.brand-buttons'); });
        });
    });
    Auth::routes();
    Route::group(['middleware' => ['role:admin|user', 'auth']], function () {
        Route::resource('bread',  'BreadController');   //create BREAD (resource)
        Route::resource('users',        'UsersController');
        Route::get('users-list', [UsersController::class, 'getUser'])->name('users.list');
        Route::resource('roles',        'RolesController');
        Route::resource('mail',        'MailController');
        Route::get('prepareSend/{id}',        'MailController@prepareSend')->name('prepareSend');
        Route::post('mailSend/{id}',        'MailController@send')->name('mailSend');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');

        Route::resource('news-category', 'NewsCategoryController');
        Route::get('news-category-list', [NewsCategoryController::class, 'getNewsCategory'])->name('news-category.list');

        Route::resource('news', 'NewsController');
        Route::get('news-list', [NewsController::class, 'getNews'])->name('news.list');
        Route::post('update-slide/{id}', [NewsController::class, 'slide'])->name('news.update.slide');

        Route::resource('learns', 'LearnsController');
        Route::get('learns-list', [LearnsController::class, 'getLearns'])->name('learns.list');

        Route::resource('bank-soal', 'BankSoalController');
        Route::get('bank-soal-list', [BankSoalController::class, 'getBankSoal'])->name('bank-soal.list');

        Route::get('sub-soal/{bank_soal_id}', [SubSoalController::class, 'index'])->name('sub-soal.index');
        Route::get('sub-soal-list/{bank_soal_id}', [SubSoalController::class, 'getSubSoal'])->name('sub-soal.list');
        Route::get('sub-soal-create/{bank_soal_id}', [SubSoalController::class, 'create'])->name('sub-soal.create');
        Route::post('sub-soal-store', [SubSoalController::class, 'store'])->name('sub-soal.store');
        Route::DELETE('sub-soal-delete/{id}', [SubSoalController::class, 'destroy'])->name('sub-soal.delete');

        Route::get('sub-soal-edit/{id}/{bank_soal_id}', [SubSoalController::class, 'edit'])->name('sub-soal.edit');
        Route::post('sub-soal-update/{id}', [SubSoalController::class, 'update'])->name('sub-soal.update');

        Route::get('sub-learn/{learn_id}', [SubLearnController::class, 'index'])->name('sub-learn.index');
        Route::get('sub-learn-list/{learn_id}', [SubLearnController::class, 'getSubLearn'])->name('sub-learn.list');
        Route::get('sub-learn-create/{learn_id}', [SubLearnController::class, 'create'])->name('sub-learn.create');
        Route::post('sub-learn-store', [SubLearnController::class, 'store'])->name('sub-learn.store');
        Route::DELETE('sub-learn-delete/{id}', [SubLearnController::class, 'destroy'])->name('sub-learn.delete');

        Route::get('sub-learn-edit/{id}/{learn_id}', [SubLearnController::class, 'edit'])->name('sub-learn.edit');
        Route::post('sub-learn-update/{id}', [SubLearnController::class, 'update'])->name('sub-learn.update');

    });
});

Route::name('backend.')->group(function() {
    Route::get('user/verification', [VerificationController::class, 'verification'])->name('verification');
    Route::get('change-password', [UsersController::class, 'changePasswordForm'])->name('change_password');
    Route::post('change-password', [UsersController::class, 'changePassword'])->name('update.change_password');
        
});
