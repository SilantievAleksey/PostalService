<?php

use App\Http\Controllers\DispatchController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\UserController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
Route::post('/feedback', [FeedbackController::class, 'send'])->name('feedback.send');

Auth::routes();

Route::group([
    'prefix' => 'office',
    'middleware' => 'auth',
], function () {
    Route::get('/', [OfficeController::class, 'index'])->name('office.main');
    Route::get('/list_dispatch/{user_id}', [OfficeController::class, 'list_dispatch'])->name('office.list_dispatch');
    Route::get('/list_dispatch_info/{dispatch_id}', [OfficeController::class, 'detail_dispatch_info'])->name('office.list_dispatch_info');

    Route::group([
        'prefix' => 'dispatch',
    ], function () {
        Route::get('/create', [DispatchController::class, 'create'])->name('dispatch.create');
        Route::post('/store', [DispatchController::class, 'store'])->name('dispatch.store');
        Route::delete('/destroy/{dispatch}', [DispatchController::class, 'destroy'])->name('dispatch.destroy');
        Route::get('/edit/{dispatch}', [DispatchController::class, 'edit'])->name('dispatch.edit');
        Route::patch('/update/{dispatch}', [DispatchController::class, 'update'])->name('dispatch.update');
    });

});

Route::group([
    'prefix' => 'profile',
    'middleware' => 'auth',
], function () {
    Route::get('/', [UserController::class, 'index'])->name('profile.index');
    Route::get('/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/update', [UserController::class, 'update'])->name('profile.update');
    Route::get('/create', [UserController::class, 'create'])->name('profile.create');
    Route::post('/store', [UserController::class, 'store'])->name('profile.store');
    Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('profile.destroy');
    Route::post('/change_api_key/{user}', [UserController::class, 'change_api_key'])->name('profile.change_api_key');
});

