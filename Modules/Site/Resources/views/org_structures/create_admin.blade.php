@extends('adminlte::page')
{{-- @extends('layouts.app') --}}

@section('title', config('settings.site_name') . ' - Create Admin')

@section('content_header')
    <h1>Manage {{ ucwords($level) }}</h1>
@stop

@section('content')
    <div class="container-fluid">
        {!! Form::model($model, array('route' => ['org-structure.update-sub', 'level' => $currentLevel['name'], 'id' => $id],'method'=>'PUT')) !!}
        <div class="card">

            <div class="card-body">
                
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
                @include('modules.systems.org_structures._formCreateSub', ['isNew' => false])
                
                
                <hr>
                <div class="row">
                    <div class="col-lg-3">
                        <h5>{{ ucwords($level) }} Administrator</h5>
                        <p class="text-muted">Lorem Ipsum</p>
                    </div>
                    <div class="col-lg-9">
                        @if ($authorize)
                        <p class="text-right">
                            <button type="button" class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }} btn-sm" data-toggle="modal" data-target="#modalCreateAdmin" id="btn-create-admin">
                                Add New
                            </button>     
                        </p>   
                        @endif
                        <div class="table-responsive">
                            <table class="{{ config('adminlte.table_light') }} table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Role</th>
                                        @if ($authorize)
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $bil = 1 @endphp
                                    @foreach ($userAssignments as $userAssignment)
                                        <tr>
                                            <td>{{ $bil++ }}</td>
                                            <td>{{ $userAssignment->user->name }}</td>
                                            <td>{{ $userAssignment->user->email }}</td>
                                            <td>{{ $userAssignment->user->profile->office_no }}</td>
                                            <td>{{ $userAssignment->role->name }}</td>
                                            @if ($authorize)
                                            <td>
                                                <a href="#" class="sa-warning" data-url="{{ route('org-structure.destroy-admin', $userAssignment) }}"><i class="fa fa-trash text-danger"></i></a>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
        
                            {{-- {!! $faculties->appends(Request::except('page'))->render() !!} --}}
                        </div>
        
                        @if (count($userAssignments) <= 0)
                            <div class="mt-2 text-center">
                                <i class="fa fa-search fa-5x text-muted"></i>
                                <div class="text-bold">
                                    Could not find any items
                                </div>
                                <div class="text-muted">
                                    Try changing the filters or add a new one
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="text-right mt-5">
                    <a href="{{ $intendedUrl }}"  class="{{ config('adminlte.btn_cancel') }}">BACK</a>
                    <button type="submit" class="btn btn-primary">SAVE</button>
                </div>
            </div>
        </div>
        
        {!! Form::close() !!}
        {{-- <a href="{{ $intendedUrl }}" class="{{ config('adminlte.btn_default') }}">Go Back</a> --}}
    </div>
    @if ($authorize)
    <!-- Modal Administrator -->
    <div class="modal fade" id="modalCreateAdmin" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => ['org-structure.store-admin']]) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search-user-admin" class="col-form-label">UMMAIL ID</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="input" name="input" placeholder="Enter Recipient's username">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@um.edu.my</span>
                            </div>
                        </div>
                        
                        {{-- <input type="hidden" class="form-control" id="input-user_id" name="user_id"> --}}
                        <input type="hidden" class="form-control" id="" name="level" value="{{ $level }}">
                        <input type="hidden" class="form-control" id="" name="id" value="{{ $id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
    @endif
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<style>
    .ui-autocomplete {
    z-index:2147483647;
    }
</style>
@endpush
@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            // modal create new administrator
            // ------------------------------

            // on modal shown
            $('#modalCreateAdmin').on('shown.bs.modal', function() {
                $('#input-user-admin').focus();
            });

            // on modal close
            $('#modalCreateAdmin').on('hidden.bs.modal', function(e) {
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
                focus: function(event, ui) {
                    name = ui.item.name;
                    $("#input-user-admin").val(name + ' / ' + ui.item.desc);
                    return false;
                },
                select: function(event, ui) {
                    $("#input-user_id").val(ui.item.id);
                    return false;
                }
            }).autocomplete("instance")._renderItem = function(ul, item) {
                document.getElementById('input-user-admin').className = 'ui-autocomplete-input form-control';
                return $("<li>").append("<a>" + item.name + " / " + item.desc + "</a>").appendTo(ul);
            };
        });
    </script>
@endsection
