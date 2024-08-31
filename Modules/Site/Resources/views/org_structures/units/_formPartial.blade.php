<div class="row">
    <div class="col-lg-3">
        <h5>Group Information</h5>
        <p class="text-muted">Provide unit group information</p>
    </div>
    <div class="col-lg-9">
        
        <!-- DROPDOWN FACULTY -->
        <div class="form-group">
            <label for="selFaculties" class="form-label @if($errors->has('faculty_id')) text-danger @endif">Faculty</label>
            <select class="{{ ($errors->has('faculty_id')) ? 'form-control is-invalid':'form-control' }}" id="selFaculties" name="faculty_id" required>
                @if (isset($unit))
                <option value="{{ $unit->faculty_id }}" selected="selected">{{ $unit->faculty->name }}</option>
                @endif
            </select>
            {!! $errors->first('faculty_id', '<small class="form-text text-danger">:message</small>') !!}
        </div>

        <!-- DROPDOWN DEPARTMENT -->
        <div class="form-group">
            <label for="selDepartments" class="form-label @if($errors->has('department_id')) text-danger @endif">Department</label>
            <select class="{{ ($errors->has('department_id')) ? 'form-control is-invalid':'form-control' }}" id="selDepartments" name="department_id" required>
                <option value="">Select Department</option>

                @if (isset($unit) && !old('department_id'))
                    <option value="{{ $unit->department_id }}" selected="selected">{{ $unit->department->name }}</option>
                @endif
            </select>
            {!! $errors->first('department_id', '<small class="form-text text-danger">:message</small>') !!}
        </div>

        <!-- DROPDOWN DIVISION -->
        <div class="form-group">
            <label for="selDivisions" class="form-label @if($errors->has('division_id')) text-danger @endif">Division</label>
            <select class="{{ ($errors->has('division_id')) ? 'form-control is-invalid':'form-control' }}" id="selDivisions" name="division_id" required>
                <option value="">Select Division</option>

                @if (isset($unit) && !old('division_id'))
                    <option value="{{ $unit->division_id }}" selected="selected">{{ $unit->division->name }}</option>
                @endif
            </select>
            {!! $errors->first('division_id', '<small class="form-text text-danger">:message</small>') !!}
        </div>

        <!-- DROPDOWN SECTION -->
        <div class="form-group">
            <label for="selSections" class="form-label @if($errors->has('section_id')) text-danger @endif">Section</label>
            <select class="{{ ($errors->has('section_id')) ? 'form-control is-invalid':'form-control' }}" id="selSections" name="section_id" required>
                <option value="">Select Section</option>

                @if (isset($unit) && !old('section_id'))
                    <option value="{{ $unit->section_id }}" selected="selected">{{ $unit->section->name }}</option>
                @endif
            </select>
            {!! $errors->first('section_id', '<small class="form-text text-danger">:message</small>') !!}
        </div>

    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-3">
        <h5>Unit Information</h5>
        <p class="text-muted">Provide unit information</p>
    </div>
    <div class="col-lg-9">
        
        <div class="form-group">
            <label for="inputName" class="form-label">Full name</label>
            {!! Form::text('name', null, array('id' => 'inputName', 'placeholder' => 'Enter role name','class' => 'form-control', 'required' => 'required')) !!}
        </div>

        <div class="form-group">
            <label for="inputDescription" class="form-label">Active</label>
            <div class="">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="input_active" @if($unit->active??true==true) checked @endif data-id="{{ $unit->id ?? null }}">
                    <label class="custom-control-label" for="input_active"></label>
                </div>
            </div>
        </div>
    </div>
</div>