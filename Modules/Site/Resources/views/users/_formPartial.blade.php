@if ($user->user_type_id != \Modules\Site\Entities\UserType::PUCLIC_USER)
    <div class="row">
        <div class="col-lg-3">
            <h5>User Information</h5>
            <p class="text-muted">User information from third party information (HRIS,MAYA)</p>
        </div>
        <div class="col-lg-9">
           
            @if (!isset($user))
                <p class="text-muted">
                    Please provide the staff no you would like to add. 
                </p>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="inputEmailId">UMMAIL ID</label>
                            <div class="input-group mb-3">
                                {!! Form::text('email_id', null, array('placeholder' => 'Enter UMMAIL ID','class' => 'form-control', 'id' => 'inputEmailId', 'required' => 'required','autofocus' => true)) !!}
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="getStaff">Find</button>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Please provide staff no value
                            </div>
                        </div> 
                        <div id="error_message" class="text-danger"></div>
                    </div>
                    
                </div>
                <div id="userInformation" style="display: @if($user) block @else none @endif;">
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-sm-5 col-5">
                            <div id="showImage"></div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-7 col-7">
                            <div class="form-group">
                                <label for="inputName">Name</label>
                                <div id="showName"></div>
                            </div> 
                            <div class="form-group">
                                <label>Email</label>
                                <div id="showEmail"></div>
                            </div> 
                        </div>
                    </div>
                </div>
            @else 
                <div id="showImage">
                    <img src="https://portal.um.edu.my/ihris/gambar_staff/{{ $user->profile->salary_no }}.jpg" style="width:100px" class="img-thumbnail">
                </div>
                <div class="font-weight-bold">{{ $user->name }}</div>
                <div>{{ $user->email }}</div>
            @endif
        </div>
    </div>
    <div id="departmentInformation" style="display:@if($user) block @else none @endif;">
        <hr>
        <div class="row">
            <div class="col-lg-3">
                <h5>Department</h5>
                <p class="text-muted">Assign staff with faculty and department</p>
            </div>
            <div class="col-lg-9">
                <div class="form-group">
                    <label for="selFaculties" class="form-label">Faculty</label>
                    <div id="showFaculty">{{ (isset($user->profile->ptj->name)) ? $user->profile->ptj->name: null }}</div>
                </div>
                <div class="form-group">
                    <label for="selDepartments" class="form-label">Department</label>
                    <div id="showDepartment">{{ (isset($user->profile->department->name)) ? $user->profile->department->name: null }}</div>
                </div>
            </div>
        </div>
    </div>
    <div id="contactInformation" style="display:@if($user) block @else none @endif;">
        <hr>
        <div class="row">
            <div class="col-lg-3">
                <h5>Contact Information</h5>
                <p class="text-muted">The user's contact detail</p>
            </div>
            <div class="col-lg-9">
                <div class="form-group">
                    <label for="inputPhoneNo">Phone No</label>
                    <div id="showPhoneNo">{{ (isset($user)) ? $user->profile->office_no:"" }}</div>
                </div>
                {{-- <div class="form-group">
                    <label for="inputHandphoneNo">Handphone No</label>
                    {!! Form::text('hp_no', null, array('placeholder' => 'Enter handphone no','class' => 'form-control', 'id' => 'inputHandphoneNo', 'maxlength' => 20, 'required'=>'required')) !!}
                </div> --}}
            
            </div>
        </div>
    </div>
    <div id="roleInformation" style="display: @if($user) block @else none @endif;">
        <hr>
        <div class="row">
            <div class="col-lg-3">
                <h5>Role</h5>
                <p class="text-muted">Give the user role permission using the system</p>
            </div>
            <div class="col-lg-9">
                @foreach ($roles as $key => $role)
                <div class="col-12 col-lg-6 col-md-6">
                    <div class="inputGroup">
                        {!! Form::checkbox('roles[]', $role->name, null, ['id' => 'radio'.$role->name, 'checked' => (in_array($role->name, $userRole)) ? true:false]) !!}
                        <label for="radio{{ $role->name }}">{{ $role->name }} <br> <small class="text-muted">{{ $role->description }}</small></label>
                    </div>
                </div>
                @endforeach
                {{-- {!! Form::select('roles[]', $roles, [], array('class' => 'form-control','multiple')) !!} --}}
            </div>
        </div>
    </div>
    
@else
    {{-- this form for laravel not setup with cas login --}}
    <div class="row">
        <div class="col-lg-3">
            <h5>User Information</h5>
            <p class="text-muted">The user's information detail</p>
        </div>
        <div class="col-lg-9">
            <div class="form-group">
                <label for="inputName">Name</label>
                {!! Form::text('name', null, array('placeholder' => 'Enter name','class' => 'form-control', 'id' => 'inputName', 'required' => 'required', 'maxlength' => 191)) !!}
            </div>
        
            <div class="form-group">
                <label for="inputEmail">Email</label>
                {!! Form::email('email', null, array('placeholder' => 'Enter email address','class' => 'form-control', 'id' => 'inputEmail', 'required' => 'required', 'maxlength' => 191)) !!}
            </div>
        
            <div class="form-group">
                <label for="inputPassword">Password</label>
                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
            </div>
        
            <div class="form-group">
                <label for="inputConfirmPassword">Confirm Password</label>
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
            </div>
        </div>
    </div>
@endif

