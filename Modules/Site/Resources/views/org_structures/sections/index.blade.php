@extends('adminlte::page')

@section('title', config('settings.site_name') . ' - Organization Structure - Sections')

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Sections</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sections</li>
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
                    <form action="{{ route('sections.index') }}" method="GET">
                        <div class="inner-addon right-addon">
                            <i class="fa fa-search"></i>
                            {!! Form::text('q', $q, array('placeholder' => 'Search...','class' => 'form-control form-control')) !!}
                        </div>
                    </form>
                </div>
                <div class="col text-right">
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }}" href="{{  route('sections.create') }}">
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
                        @foreach ($sections as $section)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                <b>{{ $section->name }}</b> <br>
                                <div class="text-muted text-sm">
                                    {{ $section->faculty->name }} / {{ $section->department->name }} / {{ $section->division->name }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="id_{{ $section->id }}" @if($section->active==true) checked @endif data-id="{{ $section->id }}">
                                    <label class="custom-control-label" for="id_{{ $section->id }}"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                
                                @can('role-edit')
                                <a href="{{ route('sections.edit', $section) }}" class="{{ config('adminlte.btn_edit') }}">Edit <i class="fa fa-edit"></i></a>
                                @endcan
                                
                                @can('role-delete')
                                <button type="button" class="{{ config('adminlte.btn_delete') }} sa-warning" data-url="{{ route('sections.destroy', $section) }}">Delete <i class="fa fa-trash"></i></button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{ $sections->render() }}
            </div>
            
            @if (count($sections) <= 0)
            <div class="mt-2 text-center">
                <i class="fa fa-search fa-5x text-muted"></i>
                <div class="text-bold">
                    Could not find any items
                </div>
                <div class="text-muted">
                    Try changing the filters or add a new one
                </div>
                
                <div class="mt-3">
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-primary') }}" href="{{ route('sections.create') }}"><i class="fa fa-plus"></i> Create new section</a>    
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
                url: '{!! route('sections.update-active') !!}',
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