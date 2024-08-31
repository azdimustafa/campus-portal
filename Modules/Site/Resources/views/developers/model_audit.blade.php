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
                <div>{{ __('Declare Audit Trail in Model') }}</div>
            </div>
        </h5>
        <div class="card-body p-0">
<?php
$code = '<?php
    ....
    use OwenIt\Auditing\Contracts\Auditable; // Import the Auditable class

    // Declare the Auditable implements in the model
    class ModelName extends Model implements Auditable {
        use \OwenIt\Auditing\Auditable;

        .....
    }
?>';
echo '<pre><code class="language-php">' . htmlspecialchars($code) . '</code></pre>';
?>
        </div>
    </div>

@endsection