@extends('adminlte::page')

@section('title', config('settings.site_name') . ' - Organization Structure - Units')

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Units</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Units</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form action="{{ route('units.index') }}" method="GET">
                        <div class="inner-addon right-addon">
                            <i class="fa fa-search"></i>
                            {!! Form::text('q', $q, array('placeholder' => 'Search...','class' => 'form-control form-control')) !!}
                        </div>
                    </form>
                </div>
                <div class="col text-right">
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }}" href="{{  route('units.create') }}">
                        <i class="fa fa-plus"></i> Create new section
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="{{ config('adminlte.table_light') }}" id="roles-table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Name</th>
                            <th style="text-align: center;">Active</th>
                            <th style="min-width: 180px; width: 180px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                <b>{{ $unit->name }}</b> <br>
                                <div class="text-muted text-sm">
                                    {{ $unit->faculty->name }} / {{ $unit->department->name }} / {{ $unit->division->name }} / {{ $unit->section->name }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="id_{{ $unit->id }}" @if($unit->active==true) checked @endif data-id="{{ $unit->id }}">
                                    <label class="custom-control-label" for="id_{{ $unit->id }}"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                
                                @can('role-edit')
                                <a href="{{ route('units.edit', $unit) }}" class="{{ config('adminlte.btn_edit') }}">Edit <i class="fa fa-edit"></i></a>
                                @endcan
                                
                                @can('role-delete')
                                <button type="button" class="{{ config('adminlte.btn_delete') }} sa-warning" data-url="{{ route('units.destroy', $unit) }}">Delete <i class="fa fa-trash"></i></button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{ $units->render() }}
            </div>
            
            @if (count($units) <= 0)
            <div class="mt-2 text-center">
                <i class="fa fa-search fa-5x text-muted"></i>
                <div class="text-bold">
                    Could not find any items
                </div>
                <div class="text-muted">
                    Try changing the filters or add a new one
                </div>
                
                <div class="mt-3">
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-primary') }}" href="{{ route('units.create') }}"><i class="fa fa-plus"></i> Create new section</a>    
                </div>
            </div> 
            @endif
            
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.custom-control-input').change(function() {
            var active = $(this).prop('checked') == true ? 1 : 0; 
            var id = $(this).data('id'); 
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{!! route('units.update-active') !!}',
                data: {'active': active, 'id': id, _token: "{{csrf_token()}}"},
                success: function(data){
                    Swal.fire({
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        position: 'top-end',
                        toast: true, 
                        title: data.message,
                        icon: data.status == true? 'success':'warning',
                    });
                }
            }); // end ajax
        }); // end tootle
    }); // end document
</script>
@endsection