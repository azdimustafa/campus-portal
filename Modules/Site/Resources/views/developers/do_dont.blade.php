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


    {{-- Validation --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Request Validation') }}</div>
            </div>
        </h5>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-6">
                    <h5 class="text-danger">{{ __('Bad example') }}</h5>
                    <?php
$code = '<?php
// don\'t declare the request class in the controller
public function store(Request $request) {
    $request->validate([
        \'name\' => \'required\',
    ]);
}
?>';
echo '<pre><code class="language-php">' . htmlspecialchars($code) . '</code></pre>';
?>
                </div>
                <div class="col-lg-6">
                    <h5 class="text-success">{{ __('Good example') }}</h5>
                    <?php
$code = '<?php
// Create new request file | php artisan make:request RequestName

// Import the request class
use App\Http\Requests\RequestName;

// Declare the request class in the controller
public function store(RequestName $request) {
    ....
}
?>';
echo '<pre><code class="language-php">' . htmlspecialchars($code) . '</code></pre>';
?>
                </div>
                
            </div>

        </div>
    </div>

@endsection