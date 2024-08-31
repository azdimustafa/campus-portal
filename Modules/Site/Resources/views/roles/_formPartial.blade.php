<div class="row">
    <div class="col-lg-3">
        <h5>Role Information</h5>
        <p class="text-muted">Provide role information</p>
    </div>
    <div class="col-lg-9">
        
        <div class="form-group">
            <label for="inputName" class="form-label">Name</label>
            @if (!isset($role))
            {!! Form::text('name', null, array('id' => 'inputName', 'placeholder' => 'Enter role name','class' => 'form-control')) !!}
            @else 
            <div>{{ $role->name }}</div>
            @endif
        </div>
        

        <div class="form-group">
            <label for="inputDescription" class="form-label">Description</label>
            <div class="">
                {!! Form::text('description', null, array('id' => 'inputDescription', 'placeholder' => 'Enter role description','class' => 'form-control')) !!}
            </div>
        </div>

        {{-- <div class="form-group">
            <label for="inputLevel" class="form-label">Level</label>
            <div class="">
                {!! Form::text('level', null, array('id' => 'inputLevel', 'placeholder' => 'Enter role level','class' => 'form-control')) !!}
            </div>
        </div> --}}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-3">
        <h5>Access Control</h5>
        <p class="text-muted">Control the access level for this role</p>
    </div>
    <div class="col-lg-9">
        <div class="row">
            @foreach($permission as $value)
    
            <div class="col-lg-4 mt-3">
                
                    @if (isset($rolePermissions))
                    <h5>{{ Str::ucfirst($value->name) }}</h5>

                    @foreach ($value->children as $item)
                    <div class="form-check">
                        <label>
                            {{ Form::checkbox('permission[]', $item->name, in_array($item->id, $rolePermissions) ? true : false, array('class' => 'name')) }}        
                            {{ $item->name }} 
                        </label>
                    </div>
                    @endforeach

                    
                    @else
                    <h5>{{ Str::ucfirst($value->name) }}</h5>

                    @foreach ($value->children as $item)
                    <div class="form-check">
                        <label>
                            {{ Form::checkbox('permission[]', $item->name, false, array('class' => 'name', 'id' => 'inputRoles')) }}        
                            {{ $item->name }} 
                        </label>
                    </div>
                    @endforeach
                    @endif
                    
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div>