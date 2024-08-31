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
use Modules\Site\Http\Controllers\ModuleController;

Route::post('modules/update-active/', [ModuleController::class, 'updateActive'])->name('site.modules.update-active');
Route::put('modules/{module}/update-owner/', [ModuleController::class, 'updateOwner'])->name('site.modules.update-owner');
Route::resource('modules', 'ModuleController', [
    'as' => 'site'
]);
