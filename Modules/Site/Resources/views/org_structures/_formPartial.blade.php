<div class="row">
    <div class="col-lg-3">
        <h5>Edit</h5>
    </div>
    <div class="col-lg-9">
        {{ Form::open(['method' => 'put']) }}
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="inputName" class="form-label">{{ $levelTitle }} name</label>
                    {!! Form::text('name', null, array('id' => 'inputName', 'placeholder' => 'Enter role name','class' => 'form-control', 'required' => 'required')) !!}
                </div>
        
                <div class="form-group">
                    <label for="inputDescription" class="form-label">Active</label>
                    <div class="">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="input_active" name="active" checked>
                            <label class="custom-control-label" for="input_active"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" value="submit" name="submit" class="{{ config('adminlte.btn_primary') }}">Save</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<hr>