@extends('adminlte::page')

@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
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
    
    

    <div class="{{ config('adminlte.card_default') }}">

        <div class="card-body">
            <div class="d-flex p-0">
                <div class="mr-auto">
                    @can('module-create')
                        @include('widgets._addButton', ['route' => route('site.modules.create'), 'label' => __('Add new module')])
                    @endcan
                </div>
                <div class="">
                    @include('widgets._searchForm', ['route' => route('site.modules.index')])
                </div>
            </div>
            <div class="table-responsive">
                <table class="{{ config('adminlte.table_light') }}">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Owners') }}</th>
                            <th>{{ __('Booking Available For') }}</th>
                            {{-- <th class="text-center">{{ __('Active') }}</th> --}}
                            <th style="min-width: 150px; width: 150px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $module)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $module->code }}</td>
                                <td>
                                    <b>{{ $module->name }}</b>
                                    <div class="text-muted text-sm">{{ $module->description }}</div>
                                </td>
                                <td>
                                    @if (count($module->owners) == 0)
                                        <span class="font-italic text-muted">No data available</span>
                                    @else 
                                        <ul>
                                            @foreach ($module->owners as $owner)
                                                <li>
                                                    <div class="text-bold text-sm"><i class="fa fa-user fa-xs"></i> {{ $owner->user->name }}</div>
                                                    <div class="text-sm text-muted"><i class="fa fa-envelope"></i> {{ $owner->user->email }}</div>
                                                </li>
                                            @endforeach
                                        </ul>

                                    @endif
                                </td>
                                <td>
                                    <ol>
                                        @foreach ($module->bookingAvailableFor as $item)
                                            <li>{{ $item->name }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                {{-- <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="id_{{ $module->id }}" @if($module->active==true) checked @endif data-id="{{ $module->id }}">
                                        <label class="custom-control-label" for="id_{{ $module->id }}"></label>
                                    </div>
                                </td> --}}
                                <td class="text-right">
                                    {{-- Edit button --}}
                                    @include('widgets._editButton', ['route' => route('site.modules.edit', $module)])
    
                                    {{-- Delete button --}}
                                    @include('widgets._deleteButton', ['route' => route('site.modules.destroy', $module)])
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-3">
                {!! $modules->appends(Request::except('page'))->render() !!}
            </div>

            @if (count($modules) <= 0)
            <div class="text-center mt-2">
                    @include('widgets._emptyList')
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.custom-control-input').change(function() {
            var input = $(this);
            var active = $(this).prop('checked') == true ? 1 : 0; 
            var id = $(this).data('id'); 

            Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '{!! route('site.modules.update-active') !!}',
                        data: {'active': active, 'id': id, _token: "{{csrf_token()}}"},
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
                            
                        }
                    }); // end ajax
                }
                else {
                    console.log('cancel button clicked');
                    // console.log(input);
                    // input.toggle();
                    input.prop("checked", !input.prop("checked"));
                }
            })
        }); // end tootle
    }); // end document
</script>
@endsection