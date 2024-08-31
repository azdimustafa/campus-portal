@extends('adminlte::page')
{{-- @extends('layouts.app') --}}

@section('title', config('settings.site_name') . ' - ' . $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
        
    {!! Form::open(array('route' => ['site.org-structure.store-sub', 'level' => $nextLevel['name'], 'id' => $id],'method'=>'POST')) !!}
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
    @include('site::org_structures.manage_admins._groupInformation', ['isNew' => true])
    
    <div class="row">
        <div class="col-lg-3">
            <h5>{{ $levelTitle }} Information</h5>
            <p class="text-muted">Provide section information</p>
        </div>
        <div class="col-lg-9">
            
            <div class="card">
                <div class="card-body">
                    @include('site::org_structures._formCreateSub')        
                </div>
            </div>
        </div>
    </div>

    <div class="text-right">
        <a href="{{ $intendedUrl }}"  class="{{ config('adminlte.btn_cancel') }}">BACK</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    {!! Form::close() !!}
    
@endsection