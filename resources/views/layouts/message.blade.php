@if(session()->has('success'))
    <div class="alert alert-success">
        {!! session()->get('success') !!}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger">
        @if (is_array(session()->get('error')))
            <ul>
                @foreach (session()->get('error') as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        @else
            {!! session()->get('error') !!}
        @endif
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif