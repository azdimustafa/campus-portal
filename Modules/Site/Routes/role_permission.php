<?php

use Illuminate\Support\Facades\Route;
use Modules\Site\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Logged As Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::resource('roles', 'RoleController', ['as' => 'site'])->middleware('can:site-manage-permission');
Route::get('getAjaxRole', [RoleController::class, 'requestAjax'])->name('site.roles.requestAjax')->middleware('can:site-manage-permission');
