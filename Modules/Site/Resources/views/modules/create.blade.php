@extends('adminlte::page')

@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.modules.index') }}">{{ __('site::module.title') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')

<div class="container">

    {!! Form::open(['route' => ['site.modules.store'], 'method' => 'post']) !!}

        {{-- Module information --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('page.label_module_information') }}</h5>
                    </div>
                    <div class="card-body">
                        {{-- Load form module --}}
                        @include('site::modules._formModule')
                    </div>
                </div>
            </div>
        </div>

        <hr>

        {{-- Owner list --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('page.label_module_owner') }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-left">
                            <button type="button" class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }} btn-sm" data-toggle="modal" data-target="#myModal" id="btnShowModal">
                                <i class="fa fa-plus"></i> {{ __('site::module.add_owner') }}
                            </button>  
                        </p>
                        @include('site::modules._ownerList', ['users' => []])
                    </div>
                </div>
            </div>
        </div>
    
        {{-- button --}}
        <div class="d-flex justify-content-between">
            <div>
                @include('widgets._backButton')
            </div>
            <div>
                @include('widgets._submitButton')
            </div>
        </div>
            
    {!! Form::close() !!}

</div>

@include('site::.modules._modalOwner')
@endsection