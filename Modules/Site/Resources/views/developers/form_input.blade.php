@extends('adminlte::page')

@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Developer') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/highlight/styles/a11y-dark.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('vendor/highlight/highlight.min.js') }}"></script>
    <script>hljs.highlightAll();</script>
@endpush
@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                {{-- TEXTFIELD --}}
                <div class="{{ config('adminlte.card_default') }}">
                    <h5 class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ __('Textfield') }}</div>
                        </div>
                    </h5>
                    <div class="card-body">
                        {{ Form::open(['route' => 'site.developer.submit-form-input', 'method' => 'post']) }}
                        <div class="form-group">
                            <label for="input-input_name" class="col-form-label">{{ __('Textfield') }}</label>
                            <div class="">
                                @include('widgets.forms._textfield', [
                                    'type' => 'text',
                                    'name' => 'input_name',
                                    'placeholder' => 'Placeholder',
                                    'hint' => 'Enter hint here',
                                    'required' => false,
                                    'maxlength' => 10,
                                ])
                            </div>
                        </div>
                        @include('widgets._submitButton', ['label' => 'Test validation'])

                        
                        {{ Form::close() }}
                    </div>
                    <div class="card-footer">
                <?php
                $code = "<div class=\"form-group\">
    <label for=\"input-input_name\" class=\"col-form-label\">{{ __('Textfield') }}</label>
    <div class=\"\">
        @include('widgets.forms._textfield', [
            'type' => 'text',
            'name' => 'input_name',
            'placeholder' => 'Placeholder',
            'hint' => 'Enter hint here',
            'required' => false,
            'maxlength' => 10,
        ])
        <!-- Add key 'defaultValue' if you want to set default value -->
    </div>
</div>";
                        echo '<pre><code class="language-sql">' . htmlspecialchars($code) . '</code></pre>';
                        ?>
                    </div>
                </div><!-- /.card -->

                {{-- DROPDOWN --}}
                <div class="{{ config('adminlte.card_default') }}">
                    <h5 class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ __('Dropdown') }}</div>
                        </div>
                    </h5>
                    <div class="card-body">
                        {{ Form::open(['route' => 'site.developer.submit-form-input', 'method' => 'post']) }}
                        <div class="form-group">
                            <label for="input-input_name" class="col-form-label">{{ __('Dropdown') }}</label>
                            <div class="">
                                @include('widgets.forms._dropdown', [
                                    'type' => 'text',
                                    'name' => 'input_name',
                                    'placeholder' => '- Select one -',
                                    'hint' => 'Enter hint here',
                                    'required' => false,
                                    'items' => [
                                        '1' => 'Option 1',
                                        '2' => 'Option 2',
                                    ],
                                ])
                            </div>
                        </div>
                        @include('widgets._submitButton', ['label' => 'Test validation'])

                        
                        {{ Form::close() }}
                    </div>
                    <div class="card-footer">
                <?php
                $code = "<div class=\"form-group\">
    <label for=\"input-input_name\" class=\"col-form-label\">{{ __('Dropdown') }}</label>
    <div class=\"\">
        @include('widgets.forms._dropdown', [
            'type' => 'text',
            'name' => 'input_name',
            'placeholder' => '- Select one -',
            'hint' => 'Enter hint here',
            'required' => false,
            'items' => [
                '1' => 'Option 1',
                '2' => 'Option 2',
            ],
        ])
    </div>
</div>";
                        echo '<pre><code class="language-sql">' . htmlspecialchars($code) . '</code></pre>';
                        ?>
                    </div>
                </div><!-- /.card -->

                {{-- TEXTAREA --}}
                <div class="{{ config('adminlte.card_default') }}">
                    <h5 class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ __('Textarea') }}</div>
                        </div>
                    </h5>
                    <div class="card-body">
                        {{ Form::open(['route' => 'site.developer.submit-form-input', 'method' => 'post']) }}
                        <div class="form-group">
                            <label for="input-input_name" class="col-form-label">{{ __('Textarea') }}</label>
                            <div class="">
                                @include('widgets.forms._textarea', [
                                    'rows' => 3,
                                    'type' => 'text',
                                    'name' => 'input_name',
                                    'placeholder' => 'Placeholder',
                                    'hint' => 'Enter hint here',
                                    'required' => false,
                                    'maxlength' => 10,
                                ])
                            </div>
                        </div>
                        @include('widgets._submitButton', ['label' => 'Test validation'])

                        
                        {{ Form::close() }}
                    </div>
                    <div class="card-footer">
                <?php
                $code = "<div class=\"form-group\">
    <label for=\"input-input_name\" class=\"col-form-label\">{{ __('Textarea') }}</label>
    <div class=\"\">
        @include('widgets.forms._textarea', [
            'rows' => 10,
            'name' => 'input_name',
            'placeholder' => 'Placeholder',
            'hint' => 'Enter hint here',
            'required' => false,
            'maxlength' => 10,
        ])
        <!-- Add key 'defaultValue' if you want to set default value -->
    </div>
</div>";
                        echo '<pre><code class="language-sql">' . htmlspecialchars($code) . '</code></pre>';
                        ?>
                    </div>
                </div><!-- /.card -->
            </div>
            <div class="col-md-6">
                {{-- CHECKBOX --}}
                <div class="{{ config('adminlte.card_default') }}">
                    <h5 class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ __('Checkbox') }}</div>
                        </div>
                    </h5>
                    <div class="card-body">
                        {{ Form::open(['route' => 'site.developer.submit-form-input', 'method' => 'post']) }}
                        <div class="form-group">
                            <label for="input-input_name" class="col-form-label">{{ __('Checkbox') }}</label>
                            <div class="">
                                @include('widgets.forms._checkbox', [
                                    'id' => 'checkbox_id',
                                    'name' => 'input_name',
                                    'check_value' => '1',
                                    'label' => 'Yes, I agree with the statement below.',
                                ])
                            </div>
                        </div>                        
                        {{ Form::close() }}
                    </div>
                    <div class="card-footer">
                <?php
                $code = "<div class=\"form-group\">
<label for=\"input-input_name\" class=\"col-form-label\">{{ __('Checkbox') }}</label>
    <div class=\"\">
        @include('widgets.forms._checkbox', [
            'id' => 'checkbox_id',
            'name' => 'input_name',
            'check_value' => '1',
            'label' => 'Yes, I agree with the statement below.',
        ])
    </div>
</div>";
                        echo '<pre><code class="language-sql">' . htmlspecialchars($code) . '</code></pre>';
                        ?>
                    </div>
                </div><!-- /.card -->

                {{-- RADIO BUTTON --}}
                <div class="{{ config('adminlte.card_default') }}">
                    <h5 class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ __('Radio button') }}</div>
                        </div>
                    </h5>
                    <div class="card-body">
                        {{ Form::open(['route' => 'site.developer.submit-form-input', 'method' => 'post']) }}
                        <div class="form-group">
                            <label for="input-input_name" class="col-form-label">{{ __('Radio button') }}</label>
                            <div class="">
                                @include('widgets.forms._radiobutton', [
                                    'id' => 'radio_id',
                                    'name' => 'input_radio',
                                    'check_value' => '1',
                                    'list' => [
                                        '1' => 'Yes',
                                        '2' => 'No',
                                    ],
                                ])
                            </div>
                        </div>                        
                        {{ Form::close() }}
                    </div>
                    <div class="card-footer">
                <?php
                $code = "<div class=\"form-group\">
<label for=\"input-input_name\" class=\"col-form-label\">{{ __('Radio button') }}</label>
    <div class=\"\">
        @include('widgets.forms._radiobutton', [
            'id' => 'radio_id',
            'name' => 'input_radio',
            'check_value' => '1',
            'list' => [
                '1' => 'Yes',
                '2' => 'No',
            ],
        ])
    </div>
</div>";
                        echo '<pre><code class="language-sql">' . htmlspecialchars($code) . '</code></pre>';
                        ?>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>


        
    </div><!-- /.container-fluid -->

    

@endsection