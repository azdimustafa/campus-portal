@extends('adminlte::page')

@section('title', 'Create New Division')
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Create new section</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.index') }}">Sections</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create new section</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')

    {!! Form::open(array('route' => 'sections.store','method'=>'POST')) !!}
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
            @include('modules.systems.org_structures.sections._formPartial')
            <div class="text-right">
                <a href="{{ $intendedUrl }}"  class="{{ config('adminlte.btn_cancel') }}">CANCEL</a>
                <button type="submit" class="btn btn-primary">CREATE</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
@section('js')
<script src="{{ asset('js/select.js') }}"></script>
<script>
    $(document).on('select2:open', () => {
        document.querySelector('#selFaculties').focus();
    });

    function select2Department(id) {
        $("#selDepartments").select2({
            placeholder: "Select Department",
            width: '100%',
            ajax: {
                url: "/select2/departments/" + id,
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    function select2Division(id) {
        $("#selDivisions").select2({
            placeholder: "Select Division",
            width: '100%',
            ajax: {
                url: "/select2/divisions/" + id,
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }
    
    $(document).ready(function() {
        var facultyId = $('#selFaculties').val();
        var departmentId = $('#selDepartments').val();
        select2Department(facultyId);
        select2Division(departmentId);

        // dropdown faculty change
        $('#selFaculties').on('change', function() {
            facultyId = $('#selFaculties').val();
            $('#selDepartments').val(null).trigger('change');
            select2Department(facultyId);
        });

        // dropdown department change
        $('#selDepartments').on('change', function() {
            departmentId = $('#selDepartments').val();
            $('#selDivisions').val(null).trigger('change');
            select2Division(departmentId);
        });
    });
</script>
@endsection