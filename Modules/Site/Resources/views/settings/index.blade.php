@extends('adminlte::page')

@section('title', $title)
@php
$google = '## Kemaskini dalam fail .env
GOOGLE_CLIENT_ID=<google_client_id>
GOOGLE_CLIENT_SECRET=<google_client_secret>
GOOGLE_REDIRECT_URL=${APP_URL}/auth/google/callback';

$cas = '## Kemaskini dalam fail .env
## /cas/login?service (For Staff)
## /cas/loginStudent?service (For Student)
## /cas/loginAllType?service (For staff & Student)
CAS_HOSTNAME=sso.um.edu.my
CAS_REAL_HOSTS=${CAS_HOSTNAME}
CAS_SESSION_NAME=username
CAS_REDIRECT_PATH=${APP_URL}/auth/cas/authenticated
CAS_LOGOUT_URL=https://${CAS_HOSTNAME}/cas/logout?RedirectUrl=${APP_URL}/auth/cas/logout
CAS_LOGIN_URL=https://${CAS_HOSTNAME}/cas/loginAllType?service=${CAS_REDIRECT_PATH}';
@endphp
@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/highlight/styles/a11y-dark.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('vendor/highlight/highlight.min.js') }}"></script>
    <script>hljs.highlightAll();</script>
@endpush

@section('content_header')
    <div class="d-flex">
        <div class="mr-auto p-2">
            <h1>{{ $title }}</h1>
        </div>
        <div class="p-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        {{ Form::open(['route' => 'site.settings.store', 'method' => 'post']) }}

        <div class="{{ config('adminlte.card_default') }}">
            <h5 class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div><i class="fa fa-file"></i> {{ __('Setting Form') }}</div>
                </div>
            </h5>
            <div class="card-body">
                {{-- SITE NAME --}}
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">{{ __('Site Name') }}</label>
                    <div class="col-sm-10">
                        {{ Form::text('site_name', old('site_name', $settings['site_name']), ['class' => 'form-control' . ($errors->has('site_name') ? ' is-invalid' : '')]) }}
                        @error('site_name')
                            <div class="invalid-feedback">{{ $errors->first('site_name') }}</div>
                        @enderror
                    </div>
                </div>

                {{-- ENABLE GOOGLE SIGN IN --}}
                <div class="form-group row">
                    <label  class="col-sm-2">{{ __('Enable google sign in') }}</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            {!! Form::checkbox('google_enable', 'yes', old('google_enable', $settings['google_enable'] == 'yes') ? true : null, ['class' => 'form-check-input', 'id' => 'input-google']) !!}
                            <label class="form-check-label" for="input-google">
                                {{ __('Yes') }}
                            </label>
                        </div>
                        <?php echo '<pre><code class="language-php">' . htmlspecialchars($google) . '</code></pre>'; ?>
                    </div>
                </div>

                {{-- ENABLE CAS SIGN IN --}}
                <div class="form-group row">
                    <label  class="col-sm-2">{{ __('Enable CAS sign in') }}</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            {!! Form::checkbox('cas_enable', 'yes', old('cas_enable', $settings['cas_enable'] == 'yes') ? true : null, ['class' => 'form-check-input', 'id' => 'input-cas']) !!}
                            <label class="form-check-label" for="input-cas">
                                {{ __('Yes') }}
                            </label>
                        </div>
                        <?php echo '<pre><code class="language-php">' . htmlspecialchars($cas) . '</code></pre>'; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                @include('widgets._submitButton', ['isUpdate' => true])
            </div>
        </div>

        {{ Form::close() }}
    </div>
@endsection
