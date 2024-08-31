@php $title="Home" @endphp
@extends('adminlte::page')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
<style type="text/css">
    .zebra  {
        background: #e0e0e0;
    }
</style>
@endpush

@section('title', $title)
@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
   
</div>
@stop

@section('content')
<div class="container-fluid">

</div>
@endsection