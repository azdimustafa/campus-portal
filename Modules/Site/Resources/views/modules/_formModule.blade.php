<div class="form-group col-lg-4">
    <label for="inputCode" class="form-label">{{ __('site::module.code') }}</label>
    <div class="">
        {!! Form::text('code', null, array('id' => 'inputCode', 'placeholder' => __('site::module.code_placeholder'),'class' => 'form-control', 'maxlength' => 50, 'style' => 'text-transform: uppercase')) !!}
    </div>
</div>
<div class="form-group col-lg-8">
    <label for="inputName" class="form-label">{{ __('site::module.name') }}</label>
    <div class="">
        {!! Form::text('name', null, array('id' => 'inputName', 'placeholder' => __('site::module.name_placeholder'),'class' => 'form-control', 'maxlength' => 255)) !!}
    </div>
</div>
<div class="form-group col-lg-12">
    <label for="inputDescription" class="form-label">{{ __('site::module.description') }}</label> <span class="text-sm text-muted">*{{ __('system.optional') }}</span>
    <div class="">
        {!! Form::text('description', null, array('id' => 'inputDescription', 'placeholder' => __('site::module.description_placeholder'),'class' => 'form-control', 'maxlength' => 255)) !!}
    </div>
</div>

<div class="form-group col-lg-12">
    <label for="">Booking Available For</label>
    <div class="">
        @foreach ($userTypes as $key => $value)
            <div class="icheck-primary d-inline mr-5">
                {!! Form::checkbox('booking_available_for[]', $key, null, ['id' => 'userType'.$key]) !!}
                <label for="userType{{ $key }}" class="form-check-label">{{ $value }}</label>
            </div>    
        @endforeach
    </div>
</div>