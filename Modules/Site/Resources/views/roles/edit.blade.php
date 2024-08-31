@extends('adminlte::page')

@section('title', 'Edit Role')
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Edit Role ({{ $role->name }})</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $role->name }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop
@section('content')

    {!! Form::model($role, ['method' => 'PATCH','route' => ['site.roles.update', $role->id]]) !!}
    <div class="card">
        <div class="card-body">
            
            @include('site::roles._formPartial')
            <div class="text-right">
                <a href="{{ route('site.roles.index') }}"  class="{{ config('adminlte.btn_cancel') }}">CANCEL</a>
                <button type="submit" class="btn btn-primary">UPDATE</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection 