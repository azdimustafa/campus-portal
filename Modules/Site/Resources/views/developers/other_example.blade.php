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
                <div>{{ __('Declare backUrl session in controller') }}</div>
            </div>
        </h5>
        <div class="card-body p-0">
<?php
$code = '<?php
public function index()
{
    ........

    session()->put(\'backUrl\', config(\'app.https\') ? str_replace(\'http\', \'https\', URL::full()) : URL::full());
    return $this->view([$this->baseView, \'index\'])->with(\'title\', __(\'Set title\'))
}

public function update(Request $request) {
    
    ........

    return redirect()->to(session()->has(\'backUrl\') ? session()->get(\'backUrl\') : route(\'units.index\'))->with(\'toast_success\', __(\'message.update_success\'));

}
?>';
echo '<pre><code class="language-php">' . htmlspecialchars($code) . '</code></pre>';
?>
        </div>
    </div>

    {{-- BLADE EXAMPLE --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Blade Template') }}</div>
            </div>
        </h5>
        <div class="card-body p-0">
<?php
$code = '@extends(\'adminlte::page\')

@section(\'title\', $title)

@section(\'content_header\')
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1>{{ $title }}</h1>
        </div>
        <div class="p-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route(\'home\') }}">{{ __(\'Home\') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
@stop

@section(\'content\')
<div class="container-fluid"></div>
@endsection
';
echo '<pre><code class="language-sql">' . htmlspecialchars($code) . '</code></pre>';
?>
        </div>
    </div>

    {{-- Card example --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Blade Template') }}</div>
            </div>
        </h5>
        <div class="card-body p-0">
<?php
$code = '<div class="{{ config(\'adminlte.card_default\') }}">
    <h5 class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div><i class="fa fa-list"></i> {{ __(\'Title\') }}</div>
            <div>
                @include(\'widgets._addButton\', [\'route\' => route(\'site.roles.create\'), \'label\' => __(\'Add Button\')])
            </div>
        </div>
    </h5>
    <div class="card-body">
    </div>
</div>
';
echo '<pre><code class="language-sql">' . htmlspecialchars($code) . '</code></pre>';
?>
        </div>
    </div>

@endsection