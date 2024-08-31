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
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>@include('widgets._searchForm', ['route' => route('site.roles.index'), 'placeholder' => 'Search role...'])</div>
                <div>
                    @include('widgets._addButton', ['route' => route('site.roles.create'), 'label' => __('Create new role')])
                </div>
            </div>
        </h5>
        <div class="card-body">
            <div class="alert alert-dark">{{ __('Role name must be in camel case. Example : SuperAdmin, ModuleAdmin') }}</div>
            <div class="table-responsive">
                <table class="{{ config('adminlte.table_light') }}" id="roles-table" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>{{ __('Name') }}</th>
                            <th></th>
                            <th></th>
                            <th style="width: 20%;"></th>
                            <th style="min-width: 180px; width: 180px;" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td><b>{{ $role->name }}</b> <div class="text-sm text-muted">{{ $role->description }}</div></td>
                            <td>
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalRole{{ $role->id }}">{{ count($role->users) }} {{ __('users') }}</button>
                                @include('site::roles._modal', [
                                    'modalId' => 'modalRole' . $role->id, 
                                    'modalTitle' => __('Users for') . ' ' . $role->name, 
                                    'items' => $role->users->pluck('name')
                                ])
                            </td>
                            <td>
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalPermission{{ $role->id }}">{{ count($role->permissions) }} {{ __('permissions') }}</button>
                                @include('site::roles._modal', [
                                    'modalId' => 'modalPermission' . $role->id, 
                                    'modalTitle' => __('Permissions for') . ' ' . $role->name, 
                                    'items' => $role->permissions->pluck('name')
                                ])
                            </td>
                            <td>
                                <div class="text-muted text-sm">{{ __("Updated on") }} {{ $role->updated_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-right">
                            
                                @include('widgets._editButton', ['route' => route('site.roles.edit', $role)])
                                @include('widgets._deleteButton', ['route' => route('site.roles.destroy', $role)])
                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if (count($roles) <= 0)
            <div class="mt-2 text-center">
                <i class="fa fa-search fa-5x text-muted"></i>
                <div class="text-bold">
                    Could not find any items
                </div>
                <div class="text-muted">
                    Try changing the filters or add a new one
                </div>
                <div class="mt-3">
                    @can('users-create', Model::class)
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-primary') }}" href="{{ route('site.roles.create') }}"><i class="fa fa-plus"></i> Create new role</a>    
                    @endcan
                </div>
            </div> 
            @endif
            
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $('.myTable').dataTable();
    </script>
@endpush