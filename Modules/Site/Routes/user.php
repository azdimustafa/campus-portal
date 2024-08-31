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

use Illuminate\Support\Facades\Route;
use Modules\Site\Http\Controllers\UserController;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('site.users.index')->middleware('can:site-manage-user');
    Route::get('/create', [UserController::class, 'create'])->name('site.users.create')->middleware('can:site-manage-user');
    Route::post('/store', [UserController::class, 'store'])->name('site.users.store')->middleware('can:site-manage-user');
    Route::post('/batch-destroy', [UserController::class, 'batchDestroy'])->name('site.users.batch-destroy')->middleware('can:site-manage-user');
    Route::get('/show/{id}', [UserController::class, 'show'])->name('site.users.show')->middleware('can:site-manage-user');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('site.users.edit')->middleware('can:site-manage-user');
    Route::put('/{id}/update', [UserController::class, 'update'])->name('site.users.update')->middleware('can:site-manage-user');
    Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('site.users.destroy')->middleware('can:site-manage-user');
    Route::get('/profile', [UserController::class, 'profile'])->name('site.users.profile');
    Route::get('/profile-edit', [UserController::class, 'editProfile'])->name('site.users.edit_profile');
    Route::put('/profile-update', [UserController::class, 'updateProfile'])->name('site.users.update_profile');

    // datatables
    Route::get('/users_data', [UserController::class, 'igetUsersDatandex'])->name('site.users.getUsersData')->middleware('can:site-manage-user');
    Route::get('/roles/{id}', [UserController::class, 'getRoles'])->name('site.users.getRoles')->middleware('can:site-manage-user');

    ### LOGIN AS
    Route::get('logged-as/login/{id}', [UserController::class, 'login'])->name('site.users.logged-as.login')->middleware('can:site-manage-user');
    Route::get('logged-as/logout', [UserController::class, 'logout'])->name('site.users.logged-as.logout');
});