@extends('adminlte::page')

@section('title', config('settings.site_name') . ' - ' . $department->name)
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2">
        <h1>{{ $department->name }}</h1>
        <p class="text-muted">{{ $department->email }}</p>
    </div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ $intendedUrl }}">Departments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')

@endsection