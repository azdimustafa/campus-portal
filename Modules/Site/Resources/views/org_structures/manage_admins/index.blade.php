@extends('adminlte::page')
@section('title', config('settings.site_name') . ' - ' . $title)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
   <div class="container-fluid">
       @include('site::org_structures.manage_admins._groupInformation', ['isNew' => false])

       @if ($currentLevel['level'] > 2) 

       {!! Form::model($model, array('route' => ['site.org-structure.update-sub', 'level' => $currentLevel['name'], 'id' => $id],'method'=>'PUT')) !!}
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
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}   
           
        @endif

        @include('site::org_structures.manage_admins._formAdmin')
        <p class="text-right">
            <a href="{{ route('site.org-structure.index') }}" class="{{ config('adminlte.btn_cancel') }}">Back</a>
        </p>
   </div>
@endsection