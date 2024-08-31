@extends('adminlte::page')

@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Developer') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop


@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/highlight/styles/a11y-dark.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('vendor/highlight/highlight.min.js') }}"></script>
    <script>hljs.highlightAll();</script>
@endpush
@section('content')

    {{-- CONTROLLER --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('How to create new route') }}</div>
            </div>
        </h5>
        <div class="card-body p-0">
            <?php

$code = "<?php

/*
|--------------------------------------------------------------------------
| Web Routes | Permissions
|--------------------------------------------------------------------------
| Create new file for each module and features in the routes directory and name as 'route_name.php'. Must be singular and lowercase.
| Change 'site' to your module name
| Change 'permissions' to your route name
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
->middleware('can:site-manage-permission');";
    
echo '<pre><code class="language-php">' . htmlspecialchars($code) . '</code></pre>';
?>
        </div>
    </div>

@endsection