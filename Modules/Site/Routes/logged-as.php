<?php

use Illuminate\Support\Facades\Route;
use Modules\Site\Http\Controllers\LoggedAsController;

Route::get('logged-as', [LoggedAsController::class, 'index'])->name('logged-as.index')->middleware('can:logged-as');
Route::get('logged-as/login/{id}', [LoggedAsController::class, 'login'])->name('logged-as.login')->middleware('can:logged-as');
Route::get('logged-as/logout', [LoggedAsController::class, 'logout'])->name('logged-as.logout');