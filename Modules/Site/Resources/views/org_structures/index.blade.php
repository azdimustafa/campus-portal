@extends('adminlte::page')
{{-- @extends('layouts.app') --}}

@section('title', config('settings.site_name') . ' - Organization Structure')

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>Organization Structure</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Organization Structure</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/treeview/style.css') }}">
@endsection

@php
    $display = $treeviewOpen;
    $icon = ($treeviewOpen == 'block') ? 'fa fa-minus-square':'fa fa-plus-square text-primary';
@endphp

@section('content')
    <div class="container">
        <div class="tree">
            <form action="{{ route('site.org-structure.index') }}" method="GET">
                <div class="inner-addon right-addon col-4">
                    <i class="fa fa-search"></i>
                    {!! Form::text('q', $q, array('placeholder' => 'Search...','class' => 'form-control form-control')) !!}
                </div>
            </form>
            <ul>
                <li>
                    <span class="badge-level1"><i class="fa fa-minus-square"></i> Universiti Malaya (UM) </span>
                    <ul>
                        {{-- LOOP EACH FACULTIES --}}
                        @foreach ($faculties as $faculty)
                            @php
                                if (!in_array($faculty->id, $treeviewIds['facultyIds'])) continue;
                            @endphp
                            <li>
                                <span class="badge-level2"><i class="mr-2 fa {{ $icon }} ico"></i> <i class="fa fa-building"></i> {{ $faculty->name }} </span>
                                @if (in_array($faculty->id, $allowIds))
                                    <a href="{{ route('site.org-structure.manage-admin.index', ['level' => config('constants.model_type.faculty.name'), 'id' => $faculty->id]) }}" class="{{ config('adminlte.btn_edit') }} btn-xs" data-toggle="tooltip" data-placement="top" title="Edit and manage admin PTJ"><i class="fa fa-edit"></i></a>        
                                @endif
                                
                                {{-- LOOP DEPARTMENT --}}
                                @if (count($faculty->departments) > 0)
                                    <ul>
                                        @foreach ($faculty->departments as $department)
                                            @php
                                                if (!in_array($department->id, $treeviewIds['departmentIds'])) continue;
                                            @endphp
                                            <li style="display: {{ $display }}">
                                                <span class="badge-level2"><i class="mr-2 fa fa {{ $icon }} ico"></i> <i class="fa fa-building"></i> {{ $department->name }}</span>
                                                @if (in_array($department->id, $allowIds))
                                                    <a href="{{ route('site.org-structure.create-sub', ['level' => config('constants.model_type.department.name'), 'id' => $department->id]) }}" class="btn btn-outline-info btn-xs" data-toggle="tooltip" data-placement="top" title="Add new division"><i class="fa fa-plus"></i></a>
                                                    <a href="{{ route('site.org-structure.manage-admin.index', ['level' => config('constants.model_type.department.name'), 'id' => $department->id]) }}" class="{{ config('adminlte.btn_edit') }} btn-xs" data-toggle="tooltip" data-placement="top" title="Edit and manage admin department"><i class="fa fa-edit"></i></a>
                                                @endif

                                                {{-- LOOP DIVISION --}}
                                                @if (count($department->divisions) > 0) 
                                                    <ul>
                                                        @foreach ($department->divisions as $division)
                                                        @php
                                                            if (!in_array($division->id, $treeviewIds['divisionIds'])) continue;
                                                        @endphp
                                                        <li style="display: {{ $display }}">
                                                            <span class="badge-level2"><i class="mr-2 fa fa {{ $icon }} ico"></i>{{ $division->name }}</span>
                                                            @if (in_array($division->id, $allowIds))
                                                                <a href="{{ route('site.org-structure.create-sub', ['level' => config('constants.model_type.division.name'), 'id' => $division->id]) }}" class="btn btn-outline-info btn-xs" data-toggle="tooltip" data-placement="top" title="Add new section"><i class="fa fa-plus"></i></a>
                                                                <a href="{{ route('site.org-structure.manage-admin.index', ['level' => config('constants.model_type.division.name'), 'id' => $division->id]) }}" class="{{ config('adminlte.btn_edit') }} btn-xs" data-toggle="tooltip" data-placement="top" title="Edit and manage admin division"><i class="fa fa-edit"></i></a>
                                                                @if (in_array($division->id, $treeviewIds['ownAuthorizeIds']))
                                                                    <a href='#' data-url="{{ route('site.org-structure.destroy-sub', ['level' => config('constants.model_type.division.name'), 'id' => $division->id]) }}" class="{{ config('adminlte.btn_delete') }} btn-xs sa-warning" data-toggle="tooltip" data-placement="top" title="Delete division"><i class="fa fa-trash"></i></a>    
                                                                @endif
                                                            @endif
                                                            {{-- LOOP SECTION --}}

                                                                @if (count($division->sections) > 0) 
                                                                <ul>
                                                                    @foreach ($division->sections as $section)
                                                                    @php
                                                                        if (!in_array($section->id, $treeviewIds['sectionIds'])) continue;
                                                                    @endphp
                                                                    <li style="display: {{ $display }}">
                                                                        <span class="badge-level2"><i class="mr-2 fa fa {{ $icon }} ico"></i> {{ $section->name }}</span>
                                                                        @if (in_array($section->id, $allowIds))
                                                                            <a href="{{ route('site.org-structure.create-sub', ['level' => config('constants.model_type.section.name'), 'id' => $section->id]) }}" class="btn btn-outline-info btn-xs" data-toggle="tooltip" data-placement="top" title="Add new unit"><i class="fa fa-plus"></i></a>
                                                                            <a href="{{ route('site.org-structure.manage-admin.index', ['level' => config('constants.model_type.section.name'), 'id' => $section->id]) }}" class="{{ config('adminlte.btn_edit') }} btn-xs" data-toggle="tooltip" data-placement="top" title="Edit and manage admin section"><i class="fa fa-edit"></i></a>
                                                                            @if (!in_array($section->id, $treeviewIds['ownAuthorizeIds']))
                                                                                <a href='#' data-url="{{ route('site.org-structure.destroy-sub', ['level' => config('constants.model_type.section.name'), 'id' => $section->id]) }}" class="{{ config('adminlte.btn_delete') }} btn-xs sa-warning" data-toggle="tooltip" data-placement="top" title="Delete section"><i class="fa fa-trash"></i></a>
                                                                            @endif
                                                                        @endif
                                                                        {{-- LOOP UNIT --}}
                                                                        @if (count($section->units) > 0) 
                                                                        <ul>
                                                                            @foreach ($section->units as $unit)
                                                                                @php
                                                                                    if (!in_array($unit->id, $treeviewIds['unitIds'])) continue;
                                                                                @endphp
                                                                                <li style="display: {{ $display }}">
                                                                                    <span class="badge-level2"><i class="mr-2 fa fa {{ $icon }} ico"></i> {{ $unit->name }}</span>
                                                                                    @if (in_array($unit->id, $allowIds))
                                                                                        <a href="{{ route('site.org-structure.manage-admin.index', ['level' => config('constants.model_type.unit.name'), 'id' => $unit->id]) }}" class="{{ config('adminlte.btn_edit') }} btn-xs" data-toggle="tooltip" data-placement="top" title="Edit and manage admin unit"><i class="fa fa-edit"></i></a>
                                                                                        @if (!in_array($unit->id, $treeviewIds['ownAuthorizeIds']))
                                                                                            <a href='#' data-url="{{ route('site.org-structure.destroy-sub', ['level' => config('constants.model_type.unit.name'), 'id' => $unit->id]) }}" class="{{ config('adminlte.btn_delete') }} btn-xs sa-warning" data-toggle="tooltip" data-placement="top" title="Delete unit"><i class="fa fa-trash"></i></a>
                                                                                        @endif
                                                                                    @endif
                                                                                    
                                                                                </li>
                                                                                
                                                                            @endforeach
                                                                           
                                                                        </ul>
                                                                        @endif
                                                                        {{-- END LOOP UNIT --}}
                                                                    </li>
                                                                    @endforeach
                                                                   
                                                                </ul>
                                                            @endif
                                                            {{-- END LOOP SECTION --}}
                                                        </li>
                                                        @endforeach
                                                        
                                                    </ul>
                                                @endif
                                                {{-- END LOOP DIVISION --}}
                                            </li>
                                        @endforeach    

                                    </ul>    
                                @endif
                                {{-- END LOOP DEPARTMENT --}}
                            </li>
                        @endforeach
                        {{-- END LOOP FACULTY --}}
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('vendor/treeview/MultiNestedList.js') }}"></script>
@endsection
