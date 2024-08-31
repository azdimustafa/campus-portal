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
use Modules\Site\Http\Controllers\Organization\DepartmentController;
use Modules\Site\Http\Controllers\Organization\PtjController;

Route::prefix('organization', ['as' => 'site.organization'])->middleware('can:site-manage-organization')->group(function() {

    // PTJ
    Route::name('site.organization.ptjs.')->group(function () {
        Route::get('/ptjs', [PtjController::class, 'index'])->name('index');
        // Route::get('/ptjs/create', [PtjController::class, 'create'])->name('create')->middleware('can:site-manage-organization');
    });

    // // DEPARTMENT
    Route::name('site.organization.departments.')->group(function () {
        Route::get('/departments', [DepartmentController::class, 'index'])->name('index');
        // Route::get('/departments/create', [DepartmentController::class, 'create'])->name('create')->middleware('can:site-manage-organization');
    });

});