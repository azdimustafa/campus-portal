@extends('adminlte::page')

@section('title', config('settings.site_name') . ' - ' . $faculty->name)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2">
        <h1>{{ $faculty->name }}</h1>
        <p class="text-muted">{{ $faculty->email }}</p>
    </div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ $intendedUrl }}">Faculties</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $faculty->name }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <a href="{{ $intendedUrl }}" class="{{ config('adminlte.btn_default') }}">Go Back</a>
        </div>
    </div>
</div>

@endsection