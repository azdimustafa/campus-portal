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
use Modules\Site\Http\Controllers\DeveloperController;

Route::prefix('developer', ['as' => 'site.developer'])->name('site.developer.')->middleware('can:site-developer')->group(function() {
    Route::get('/naming-conventions', [DeveloperController::class, 'namingConvention'])->name('naming-conventions');
    Route::get('/model-audit', [DeveloperController::class, 'modelAudit'])->name('model-audit');
    Route::get('/route-name', [DeveloperController::class, 'routeName'])->name('route-name');   
    Route::get('/other-example', [DeveloperController::class, 'otherExample'])->name('other-example'); 
    Route::get('/do-dont', [DeveloperController::class, 'doDont'])->name('do-dont'); 
    Route::get('/form-input', [DeveloperController::class, 'formInput'])->name('form-input');
    Route::post('/form-input', [DeveloperController::class, 'submitFormInput'])->name('submit-form-input');
});