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
use Modules\Site\Http\Controllers\ManageAdminController;
use Modules\Site\Http\Controllers\OrgStructureController;

Route::prefix('org-structure', [
    'as' => 'site',
])->group(function() {
    Route::get('/', [OrgStructureController::class, 'index'])->name('site.org-structure.index')->middleware('can:site-manage-ptj');
    Route::get('/create-sub/{level}/{id}', [OrgStructureController::class, 'createSub'])->name('site.org-structure.create-sub');
    Route::put('/create-sub/{level}/{id}', [OrgStructureController::class, 'updateSub'])->name('site.org-structure.update-sub');
    Route::post('/create-store-sub/{level}/{id}', [OrgStructureController::class, 'storeSub'])->name('site.org-structure.store-sub');
    Route::delete('/destroy-sub/{level}/{id}', [OrgStructureController::class, 'destroySub'])->name('site.org-structure.destroy-sub');

    ## manage admin
    Route::get('/manage-admin/{level}/{id}', [ManageAdminController::class, 'index'])->name('site.org-structure.manage-admin.index');
    Route::post('/manage-admin/store/{level}/{id}', [ManageAdminController::class, 'store'])->name('site.org-structure.manage-admin.store');
});