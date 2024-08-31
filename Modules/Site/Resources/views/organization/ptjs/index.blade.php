@extends('adminlte::page')
@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">


    {{-- PTJ LIST --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-auto w-50">
                    {{ Form::open(['method' => 'get']) }}
                    <div class="input-group">
                        {{ Form::text('q', $q, ['class' => 'form-control', 'placeholder' => __('Search....')]) }}
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">{{ __('Search') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <div>
                    <button type="button" class="{{ config('adminlte.btn_add') }}"><i class="fa fa-sync"></i> {{ __('Fetch from HRIS') }}</button>
                </div>
            </div>
        </h5>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="{{ config('adminlte.table') }}" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th></th>
                            <th></th>
                            <th style="min-width: 180px; width: 180px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ptjs as $ptj)
                        <tr>
                            <td><span class="badge badge-pill badge-dark text-lg">{{ $ptj->code }}</span></td>
                            <td><b>{{ $ptj->name }}</b>@if ($ptj->active)  <span class="badge badge-success"><i class="fa fa-check"></i> {{ __('Active') }}</span> @else <span class="badge badge-danger"><i class="fa fa-times"></i> {{ __('Inactive') }}</span> @endif <div class="text-xs text-muted font-italic">{{ $ptj->name_my }}</div></td>
                            <td><i class="fa fa-envelope"></i> {!! $ptj->email ?? '<span class="text-sm font-italic text-muted">- not available -</span>' !!}</td>
                            <td>
                                @if ($ptj->is_academic) 
                                <span class="badge badge-primary">{{ __('Academic') }}</span>
                                @else
                                <span class="badge badge-warning">{{ __('Non Academic') }}</span>
                                @endif
                            </td>
                            <td>{{ count($ptj->departments) }}</td>
                            <td class="text-right">
                                {{-- @include('widgets._editButton', ['id' => $ptj->id, 'route' => route('organizations.edit', $ptj->id)]) --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- EMPTY LIST --}}
            @if (count($ptjs) <= 0)
                <div class="text-center text-muted font-italic">@include('widgets._emptyList')</div>
            @endif
            
        </div>
    </div>
</div>
@endsection