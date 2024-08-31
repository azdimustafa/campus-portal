@extends('adminlte::page')

@section('title', 'Create New Role')
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Create new role</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create new role</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')

    {!! Form::open(array('route' => 'site.roles.store','method'=>'POST')) !!}
    <div class="card">
        <div class="card-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @include('site::roles._formPartial')
            <div class="text-right">
                <a href="{{ route('site.roles.index') }}"  class="{{ config('adminlte.btn_cancel') }}">CANCEL</a>
                <button type="submit" class="btn btn-primary">CREATE</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection