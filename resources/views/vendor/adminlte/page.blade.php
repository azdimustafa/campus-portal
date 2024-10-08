@extends('adminlte::master')

@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper::class)

@if($layoutHelper->isLayoutTopnavEnabled())
@php( $def_container_class = 'container' )
@else
@php( $def_container_class = 'container-fluid' )
@endif
@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('css/site.css') }}">
@stop

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
<div class="wrapper">
    
    {{-- Top Navbar --}}
    @if($layoutHelper->isLayoutTopnavEnabled())
    @include('adminlte::partials.navbar.navbar-layout-topnav')
    @else
    @include('adminlte::partials.navbar.navbar')
    @endif
    
    {{-- Left Main Sidebar --}}
    @if(!$layoutHelper->isLayoutTopnavEnabled())
    @include('adminlte::partials.sidebar.left-sidebar')
    @endif
    
    {{-- Content Wrapper --}}
    <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">
        
        {{-- Content Header --}}
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
        
        {{-- Main Content --}}
        <div class="content">
            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                @yield('content')
            </div>
        </div>
        
    </div>
    
    {{-- Footer --}}
    <footer class="main-footer text-sm">
        <strong>Copyright © {{ date('Y') }} <a href="https://adminlte.io">Pusat Teknologi Maklumat</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
    
    {{-- Right Control Sidebar --}}
    @if(config('adminlte.right_sidebar'))
    @include('adminlte::partials.sidebar.right-sidebar')
    @endif
    
</div>
@stop

@section('adminlte_js')
@stack('js')
@yield('js')
@stop