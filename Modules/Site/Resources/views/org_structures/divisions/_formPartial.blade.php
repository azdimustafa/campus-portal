<div class="row">
    <div class="col-lg-3">
        <h5>Group Information</h5>
        <p class="text-muted">Provide division group information</p>
    </div>
    <div class="col-lg-9">
        
        <div class="form-group">
            <label for="selFaculties" class="form-label @if($errors->has('faculty_id')) text-danger @endif">Faculty</label>
            <select class="{{ ($errors->has('faculty_id')) ? 'form-control is-invalid':'form-control' }}" id="selFaculties" name="faculty_id">
                @if (isset($division))
                <option value="{{ $division->faculty_id }}" selected="selected">{{ $division->faculty->name }}</option>
                @endif
            </select>
            {!! $errors->first('faculty_id', '<small class="form-text text-danger">:message</small>') !!}
        </div>
        <div class="form-group">
            <label for="selDepartments" class="form-label @if($errors->has('department_id')) text-danger @endif">Department</label>
            <select class="{{ ($errors->has('department_id')) ? 'form-control is-invalid':'form-control' }}" id="selDepartments" name="department_id">
                <option value="">Select Department</option>
                @if (isset($division))
                <option value="{{ $division->department_id }}" selected="selected">{{ $division->department->name }}</option>
                @endif
            </select>
            {!! $errors->first('department_id', '<small class="form-text text-danger">:message</small>') !!}
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-3">
        <h5>Division Information</h5>
        <p class="text-muted">Provide division information</p>
    </div>
    <div class="col-lg-9">
        
        <div class="form-group">
            <label for="inputName" class="form-label">Full name</label>
            {!! Form::text('name', null, array('id' => 'inputName', 'placeholder' => 'Enter role name','class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            <label for="inputDescription" class="form-label">Active</label>
            <div class="">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="input_active" @if($division->active??true==true) checked @endif data-id="{{ $division->id ?? null }}">
                    <label class="custom-control-label" for="input_active"></label>
                </div>
            </div>
        </div>
    </div>
</div>