@extends('adminlte::page')
@push('css')
<link rel="stylesheet" href="{{ asset('css/radio_style.css') }}">
@endpush
@section('title', 'Edit User')
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Edit Profile</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.users.profile') }}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>
@stop
@section('content')
<div class="container-fluid">

{!! Form::model($user, ['method' => 'PUT','route' => ['site.users.update_profile']]) !!}
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
    
        @include('site::users._formProfile', ['user' => $user, 'userRole' => $userRole])
        
        <p>
            <div class="text-right">
                <a class="{{ config('adminlte.btn_default') }}" href="{{ route('site.users.profile') }}">CANCEL</a>
                <button type="submit" class="btn btn-primary">UPDATE</button>
            </div>
        </p>
    </div>

</div>
{!! Form::close() !!}
</div>
@endsection


@push('js')
<script>
    $(document).ready(function() {
        var facultyId = '';
        $('#selFaculties').on('change', function() {
            facultyId = $('#selFaculties').val();
            $('#selDepartments').val(null).trigger('change');
            $("#selDepartments").select2({
                placeholder: "Select Department",
                width: '100%',
                ajax: {
                    url: "/select2/departments/" + facultyId,
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
        });
    });
</script>
<script src="{{ asset('js/select.js') }}"></script>
@endpush