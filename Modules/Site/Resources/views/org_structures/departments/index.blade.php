@extends('adminlte::page')

@section('title', config('settings.site_name') . ' - Lookup - Departments')

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Departments</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Departments</li>
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
                    <form action="{{ route('departments.index') }}" method="GET">
                        <div class="inner-addon right-addon">
                            <i class="fa fa-search"></i>
                            {!! Form::text('q', $q, array('placeholder' => 'Search...','class' => 'form-control form-control')) !!}
                            @if ($f != null)
                                {!! Form::hidden('f', $f) !!}    
                            @endif
                        </div>
                    </form>
                </div>
                <div class="col text-right">
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }}" href="{{  route('departments.fetch') }}">
                        <i class="fa fa-download"></i> Update from HRIS
                    </a>
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }}" href="{{  route('departments.create') }}">
                        <i class="fa fa-plus"></i> Create new department
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td><code>{{ $department->id }}</code></td>
                            <td>
                                {{ $department->name }} <br>
                                @if ($department->email) <small class="text-muted"><i class="fa fa-envelope"></i> {{ ($department->email) ?? '-' }}</small> @endif
                            </td>
                            <td style="text-align: center;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="id_{{ $department->id }}" @if($department->active==true) checked @endif data-id="{{ $department->id }}">
                                    <label class="custom-control-label" for="id_{{ $department->id }}"></label>
                                </div>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('departments.show', $department) }}" class="{{ config('adminlte.btn_show') }}">View <i class="fa fa-eye"></i></a>

                                <a href="{{ route('departments.edit', $department) }}" class="{{ config('adminlte.btn_edit') }}">Edit <i class="fa fa-edit"></i></a>
                                
                                <button type="button" class="{{ config('adminlte.btn_delete') }} sa-warning" data-url="{{ route('departments.destroy', $department) }}">Delete <i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{-- {{ $departments->render() }} --}}
                {!! $departments->appends(Request::except('page'))->render() !!}
            </div>
            
            @if (count($departments) <= 0)
            <div class="mt-2 text-center">
                <i class="fa fa-search fa-5x text-muted"></i>
                <div class="text-bold">
                    Could not find any items
                </div>
                <div class="text-muted">
                    Try changing the filters or add a new one
                </div>
                
                <div class="mt-3">
                    <a class="{{ config('adminlte.btn_add', 'btn-flat btn-primary') }}" href="{{ route('departments.create') }}"><i class="fa fa-plus"></i> Create new department</a>    
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

            console.log(id);
            console.log(active);
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{!! route('departments.update-active') !!}',
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