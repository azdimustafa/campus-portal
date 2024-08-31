<?php

use Illuminate\Support\Facades\Route;
use Modules\Site\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Setting Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::prefix('settings', ['as' => 'site.settings'])->middleware('can:site-manage-setting')->name('site.settings.')->group(function() {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('/', [SettingController::class, 'store'])->name('store');
});