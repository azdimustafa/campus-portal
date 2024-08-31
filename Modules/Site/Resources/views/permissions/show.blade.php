@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1>{{ $title }}</h1>
        </div>
        <div class="p-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('site.permissions.index') }}">{{ __('Permission') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $permission->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">

    <div class="{{ config('adminlte.card_default') }}">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-3">
                    @include('widgets._backButton')
                </div>
                <div class="mr-auto">
                    @include('widgets._searchForm', ['route' => route('site.permissions.show', $permission), 'placeholder' => 'Search permission...'])
                </div>
                <div>
                    
                    @include('widgets._addButton', ['route' => route('site.permissions.create', ['id' => $permission->id]), 'label' => __('Create new permission')])
                </div>
            </div>    
        </div>
        <div class="card-body table-responsive">
            <table class="{{ config('adminlte.table_light') }}">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th></th>
                        <th style="min-width: 70px; width: 70px; max-width: 70px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $i => $permission)
                        <tr data-widget="expandable-table" aria-expanded="{{ $i == 0 ? 'true':'true' }}">
                            <td><b>{{ $permission->name }}</b></td>
                            <td class="text-right text-muted text-sm font-italic">{{ __('Updated') }} {{ $permission->updated_at->diffForHumans() }}</td>
                            <td class="text-right">
                                @include('widgets._deleteButton', ['route' => route('site.permissions.destroy', $permission)])
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            @if (count($permissions) == 0)
                <div class="text-center mt-3">
                    @include('widgets._emptyList')
                </div>
            @endif
        </div>
    </div>

</div>
@endsection