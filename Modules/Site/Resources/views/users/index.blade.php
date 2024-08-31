@extends('adminlte::page')

@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2">
        <h1>{{ $title }}</h1>
        <p class="text-sm text-muted">{{ __('Manage users, invite new users, and grant permissions.') }}</p>
    </div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop
@section('content')
<div class="container-fluid">
    
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @include('widgets._searchForm', ['route' => route('site.users.index'), 'placeholder' => __('Search user...')])
                </div>
                <div>
                    @include('widgets._addButton', ['route' => route('site.users.create'), 'label' => __('Add new user')])
                </div>
            </div>
        </h5>
        <div class="card-body p-0">
               
            <div class="table-responsive">
                <table class="{{ config('adminlte.table_light') }}">
                    <thead>
                        <tr>
                            <th style="width: 30px;"><input type="checkbox" id="select-all" class="checkbox" /></th>
                            <th style="width: 50px;">{{ __("No") }}</th>
                            <th style="width:80px;"></th>
                            <th>{{ __("Name") }}</th>
                            <th>{{ __("Contact") }}</th>
                            <th>{{ __('Roles') }}</th>
                            <th style="min-width: 200px;" width="200px"></th>
                            <th style="min-width: 160px;" width="160px"></th>
                        </tr>
                    </thead>
                
                    @foreach ($users as $key => $user)
                    <tr>
                        <td>
                            @if ($user->id != auth()->user()->id)
                            <div>
                                {{ Form::checkbox('user[]', $user->id, null, ['id' => 'checkbox', 'class' => 'checkbox']) }}
                            </div>    
                            @endif
                        </td>
                        <td>{{ ++$i }}</td>
                        <td>
                            @include('widgets._staffPhoto', ['id' => $user->profile->salary_no, 'width' => '60'])
                        </td>
                        <td>
                            <div class="font-weight-bold">
                                <a href="{{ route('site.users.show', $user) }}">{{ $user->name }}</a>
                                @if ($user->id != auth()->user()->id) 
                                <a class="btn btn-danger btn-xs" href="{{ route('site.users.logged-as.login',$user->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Impersonate') }}">
                                    <i class="fa fa-user-secret"></i> {{ __('Impersonate') }}
                                </a>
                                @endif
                            </div>
                            @if(isset($user->profile->ptj))
                                <small class="text-muted">{{ $user->profile->ptj->name ?? '' }}</small>
                            @endif
                            @if(isset($user->profile->department))
                                <br><small class="text-muted font-weight-bold">{{ $user->profile->department->name ?? '' }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="text-muted text-sm">
                                <i class="fa fa-envelope"></i> {{ $user->email }} <br>
                                <i class="fa fa-phone"></i> {{ $user->profile->office_no }}
                            </div>
                        </td>
                        <td>
                            @if(!empty($user->getRoleNames()))
                                <ul class="list-unstyled">
                                    @foreach($user->getRoleNames() as $v)
                                        <li><label class="badge badge-pill badge-dark">{{ $v }}</label></li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            <div class="text-muted text-sm">
                                {{ __('Updated') }} {{ $user->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td style="text-align: right;">
                            
                            @if (auth()->user()->id == $user->id)
                                <span class="text-sm text-muted">{{ __("It's you") }}</span>
                            @endif
                            @include('widgets._editButton', ['route' => route('site.users.edit',$user->id)])
                            @if(auth()->user()->id != $user->id)
                                @include('widgets._deleteButton', ['route' => route('site.users.destroy', $user)])       
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    

                </table>
            </div>

            @if (count($users) == 0)
                <div class="text-center">

                   @include('widgets._emptyList', ['label' => $q ? 'Your search - <b>'.$q.'</b> - dit not match any users' : 'No users found'])
                    
                </div>
                @if ($q) 
                <p class="text-muted text-center">
                    Make sure that all words are spelled correctly.<br>
                    Try different keywords.<br>
                    Try more general keywords.<br>
                    Try fewer keywords.
                </p>
                @endif
            @endif
            
            {!! $users->appends(Request::except('page'))->render() !!}
            
        </div>

    </div>
</div>
@endsection

@push('js')
    
    <script>
        $(document).ready(function() {
            $('.checkbox').on('click', function() {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
                if (checkedOne == true) {
                    $('#div-delete-all').show();
                }
                else {
                    $('#div-delete-all').hide();
                }
            });

            $('#btn-delete-all').on('click', function() {
                var id = [];
                $('input[type="checkbox"]:checked').each(function(){
                    id.push($(this).val());
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '{!! route('site.users.batch-destroy') !!}',
                    data: {'id': id, _token: "{{csrf_token()}}"},
                    success: function(data){
                        
                        Swal.fire({
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            position: 'top-end',
                            toast: true, 
                            title: data.message,
                            icon: data.status == true? 'success':'warning',
                        });

                        location.reload();
                        
                    }
                }); // end ajax
            });
        });
    </script>

@endpush