<?php

/*
|--------------------------------------------------------------------------
| Web Routes | Permissions
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use Modules\Site\Http\Controllers\PermissionController;

Route::prefix('permissions')->name('site.permissions.')->group(function() {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::post('/', [PermissionController::class, 'store'])->name('store');
    Route::get('/{permission}/show', [PermissionController::class, 'show'])->name('show');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
})
->middleware('can:site-manage-permission');