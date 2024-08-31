@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Profile</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="{{ config('adminlte.card_default') }}">
                <div class="card-body text-center">
                    <p class="card-text">
                        <img src="https://portal.um.edu.my/ihris/gambar_staff/{{ $user->profile->salary_no }}.jpg" alt="" style="width:120px;">
                        <h2>{{ $user->name }}</h2>
                        <div><i class="fa fa-envelope"></i> {{ $user->email }}</div>
                        <div><i class="fa fa-phone"></i> {{ $user->profile->office_no }}</div>
                        @if ($user->profile->hp_no)
                        <div><i class="fa fa-phone"></i> {{ $user->profile->hp_no }}</div>    
                        @endif
                        <hr>
                        <h3>{{ $user->profile->faculty->name }}</h3>
                        <h5 class="text-muted">{{ $user->profile->department->name }}</h5>
                    </p>
                </div>
            </div>
        </div>
    
    </div>
</div>

@endsection