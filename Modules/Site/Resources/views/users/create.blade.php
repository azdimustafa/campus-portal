@extends('adminlte::page')

@section('title', 'Create New User')
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Create new user</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create new user</li>
            </ol>
        </nav>
    </div>
</div>
@stop
@push('css')
<link rel="stylesheet" href="{{ asset('css/radio_style.css') }}">
@endpush
@section('content')

<div class="container-fluid">
    {!! Form::open(array('route' => 'site.users.store','method'=>'POST')) !!}

    @csrf
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
            
            @include('site::users._formPartial', ['user' => isset($user) ? $user:null, 'userRole' => []])

            

            <p id="buttonInformation" style="display: none;">
                <div class="text-right">
                    <a class="{{ config('adminlte.btn_default') }}" href="{{ route('site.users.index') }}">CANCEL</a>
                    <button type="submit" class="btn btn-primary">CREATE</button>
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
        $( "#getStaff" ).click(function(event) {
            var val = $('#inputEmailId').val();

            // start search staff details to display
            var url = "{!! url('getStaff') !!}";
            console.log(url);

            $.ajax({
                type : 'post',
                url  : url,
                data : {'id':val,_token:'{{ csrf_token() }}'},
                success:function(data){
                    
                    if (data['status'] == true) {
                        var content = data['body'];
                        console.log(content);
                        $('#error_message').html('');
                        $('#contactInformation').show();
                        $('#departmentInformation').show();
                        $('#roleInformation').show();
                        $('#buttonInformation').show();
                        $('#userInformation').show();

                        $('#showImage').html('<img src="https://portal.um.edu.my/ihris/gambar_staff/'+ content['salary_no']+'.jpg" style="width:120px;" class="img-fluid img-thumbnail">');    
                        $('#showName').html(content['name']);    
                        $('#showEmail').html(content['official_email']);    
                        $('#showPhoneNo').html(content['office_no']);    
                        $('#showFaculty').html(content['faculty']['desc']);    
                        $('#showDepartment').html(content['department']['desc']);    

                    }
                    else {
                        $('#error_message').html(data['message']);
                        $('#contactInformation').hide();
                        $('#departmentInformation').hide();
                        $('#roleInformation').hide();
                        $('#buttonInformation').hide();
                        $('#userInformation').hide();
                    }
                }
            });
        });
    });
</script>
<script src="{{ asset('js/select.js') }}"></script>
@endpush