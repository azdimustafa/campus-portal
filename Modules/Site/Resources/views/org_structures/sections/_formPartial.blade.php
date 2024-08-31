<div class="row">
    <div class="col-lg-3">
        <h5>Group Information</h5>
        <p class="text-muted">Provide section group information</p>
    </div>
    <div class="col-lg-9">
        
        <!-- DROPDOWN FACULTY -->
        <div class="form-group">
            <label for="selFaculties" class="form-label @if($errors->has('faculty_id')) text-danger @endif">Faculty</label>
            <div>{{ $model->faculty->name }}</div>
        </div>

        <!-- DROPDOWN DEPARTMENT -->
        <div class="form-group">
            <label for="selDepartments" class="form-label @if($errors->has('department_id')) text-danger @endif">Department</label>
            <div>{{ $model->department->name }}</div>
        </div>

        <!-- DROPDOWN DIVISION -->
        <div class="form-group">
            <label for="selDivisions" class="form-label @if($errors->has('division_id')) text-danger @endif">Division</label>
            <div>{{ $model->name }}</div>
        </div>

    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-3">
        <h5>Section Information</h5>
        <p class="text-muted">Provide section information</p>
    </div>
    <div class="col-lg-9">
        
        <div class="form-group">
            <label for="inputName" class="form-label">Section name</label>
            {!! Form::text('name', null, array('id' => 'inputName', 'placeholder' => 'Enter role name','class' => 'form-control', 'required' => 'required')) !!}
        </div>

        <div class="form-group">
            <label for="inputDescription" class="form-label">Active</label>
            <div class="">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="input_active">
                    <label class="custom-control-label" for="input_active"></label>
                </div>
            </div>
        </div>
    </div>
</div>