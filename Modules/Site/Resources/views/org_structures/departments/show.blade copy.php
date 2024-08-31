@extends('adminlte::page')

@section('title', config('settings.site_name') . ' - ' . $department->name)
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<style>
    .ui-autocomplete {
    z-index:2147483647;
    }
</style>
@endpush
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2">
        <h1>{{ $department->name }}</h1>
        <p class="text-muted">{{ $department->email }}</p>
    </div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ $intendedUrl }}">Departments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="card-title">Administrator</div>
                        </div>
                        <div class="col text-right">
                            <button type="button" class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }} btn-sm" data-toggle="modal" data-target="#modalCreateAdmin" id="btn-create-admin">
                                Add New
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="{{ config('adminlte.table_light') }}">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Assigned at</th>
                            <th></th>
                        </tr>
                        @php
                            $bil = 0;
                        @endphp
                        @foreach ($adminAssignments as $admin)
                            <tr>
                                <td>{{ ++$bil }}</td>
                                <td>{{ $admin->user->name }}</td>
                                <td><div class="text-muted">{{ $admin->created_at->diffForHumans() }}</div></td>
                                <td>
                                    <a href="#" class="sa-warning" data-url="{{ route('departments.destroy-assignment', $admin->id) }}"><i class="fa fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    @if (count($adminAssignments) <= 0)
                    <div class="mt-2 text-center">
                        <i class="fa fa-user-times fa-3x text-muted"></i>
                        <div class="text-bold mt-2">
                            Could not find any records
                        </div>
                        <div class="text-muted">
                            Add new administrator to complete the process
                        </div>
                    </div> 
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="card-title">Secretariat</div>
                        </div>
                        <div class="col text-right">
                            <button type="button" class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }} btn-sm" data-toggle="modal" data-target="#modalCreateSecretariat" id="btn-create-secretariat">
                                Add New
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="{{ config('adminlte.table_light') }}">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Assigned at</th>
                            <th></th>
                        </tr>
                        @php
                            $bil = 0;
                        @endphp
                        @foreach ($secretariatAssignments as $secretariat)
                            <tr>
                                <td>{{ ++$bil }}</td>
                                <td>{{ $secretariat->user->name }}</td>
                                <td><div class="text-muted">{{ $secretariat->created_at->diffForHumans() }}</div></td>
                                <td>
                                    <a href="#" class="sa-warning" data-url="{{ route('departments.destroy-assignment', $secretariat->id) }}"><i class="fa fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    @if (count($secretariatAssignments) <= 0)
                    <div class="mt-2 text-center">
                        <i class="fa fa-user-times fa-3x text-muted"></i>
                        <div class="text-bold mt-2">
                            Could not find any records
                        </div>
                        <div class="text-muted">
                            Add new administrator to complete the process
                        </div>
                    </div> 
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <a href="{{ $intendedUrl }}" class="{{ config('adminlte.btn_default') }}">Go Back</a>
        </div>
    </div>
</div>

<!-- Modal Administrator -->
<div class="modal fade" id="modalCreateAdmin" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New Administrator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => ['departments.store-admin', $department]]) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search-user-admin" class="col-form-label">Search user</label>
                        <input type="text" class="form-control" id="input-user-admin" name="name" placeholder="Type to search....">
                        <input type="hidden" class="form-control" id="input-user-admin-id" name="admin-id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            {!! Form::close() !!}
        </div>
        
    </div>
</div>

<!-- Modal Secretariat -->
<div class="modal fade" id="modalCreateSecretariat" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New Secretariat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => ['departments.store-secretariat', $department]]) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search-user-secretariat" class="col-form-label">Search user</label>
                        <input type="text" class="form-control" id="input-user-secretariat" name="name" placeholder="Type to search....">
                        <input type="hidden" class="form-control" id="input-user-secretariat-id" name="secretariat-id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            {!! Form::close() !!}
        </div>
        
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function() {

        // modal create new administrator
        // ------------------------------
        
        // on modal shown
        $('#modalCreateAdmin').on('shown.bs.modal', function () {
            $('#input-user-admin').focus();
        });
        
        // on modal close
        $('#modalCreateAdmin').on('hidden.bs.modal', function (e) {
            $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        });

        $("#input-user-admin").autocomplete({  
            minLength: 3,
            source: "{!! route('ajax.search-user') !!}",
            focus: function( event, ui ) {
                name = ui.item.name;
                $( "#input-user-admin" ).val( name + ' / ' + ui.item.desc);
                return false;
            },
            select: function( event, ui ) {
                $( "#input-user-admin-id" ).val( ui.item.id );
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            document.getElementById('input-user-admin').className='ui-autocomplete-input form-control';
            return $( "<li>" ).append( "<a>" + item.name + " / " + item.desc + "</a>" ).appendTo( ul );
        };

        // modal create new secretariat
        // ------------------------------
        
        // on modal shown
        $('#modalCreateSecretariat').on('shown.bs.modal', function () {
            $('#input-user-secretariat').focus();
        });
        
        // on modal close
        $('#modalCreateSecretariat').on('hidden.bs.modal', function (e) {
            $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        });

        $("#input-user-secretariat").autocomplete({  
            minLength: 3,
            source: "{!! route('ajax.search-user') !!}",
            focus: function( event, ui ) {
                name = ui.item.name;
                $( "#input-user-secretariat" ).val( name + ' / ' + ui.item.desc);
                return false;
            },
            select: function( event, ui ) {
                $( "#input-user-secretariat-id" ).val( ui.item.id );
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            document.getElementById('input-user-secretariat').className='ui-autocomplete-input form-control';
            return $( "<li>" ).append( "<a>" + item.name + " / " + item.desc + "</a>" ).appendTo( ul );
        };
    });
</script>
@endsection