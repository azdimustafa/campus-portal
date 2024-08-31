<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Subfission\Cas\Facades\Cas;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\CasController;

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
Route::get('/', 'HomeController@index')->name('home');
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('auth/cas', [CasController::class, 'index'])->name('auth.cas');
Route::get('auth/cas/callback', [CasController::class, 'index'])->name('auth.cas.callback');
Route::get('auth/cas/logout', [CasController::class, 'logout'])->name('auth.cas.logout');
Route::get('auth/cas/authenticated', [CasController::class, 'authenticated'])->name('auth.cas.authenticated');

## change language
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');

/**
 * All route in this group can be access only authenticated user
 */
Route::post('/logout', [LogoutController::class, 'index'])->name('logout');
Route::group(['middleware' => 'auth'], function() {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs')->middleware('can:site-view-log');    

    ###########################################################
    ## OTHERS ##
    ###########################################################
    Route::post('getStaff', 'Misc\AjaxController@getStaff')->name('ajax.getStaff');
    Route::get('search-user', 'Misc\AjaxController@searchUser')->name('ajax.search-user');

    ###########################################################
    ## FUNCTION TO READ FILE ##
    ###########################################################
    Route::get('files/read/{id}', 'FileController@read')->name('files.read');
    Route::get('files/download/{id}', 'FileController@download')->name('files.download');
});