@php
    $url = url()->previous();
    if (isset($route)) { 
        $url = $route;
    }
    else {
        if (session()->has('backUrl')) {
            $url = session()->get('backUrl');
        }
    }
@endphp
<a href="{{ $url }}" class="{{ config('adminlte.btn_back') }}">
    <i class="fa fa-arrow-left"></i> {{ __('Back') }}
</a>