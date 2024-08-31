

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="inputCode" class="form-label">{{ __('Code') }}</label>
            {!! Form::text('code', null, array('id' => 'inputCode', 'class' => 'form-control', 'required' => 'required')) !!}
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="inputShortName" class="form-label">{{ __('short name') }}</label>
            {!! Form::text('short_name', null, array('id' => 'inputShortName', 'class' => 'form-control', 'required' => 'required')) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="inputName" class="form-label">{{ __('Name (English)') }}</label>
            {!! Form::text('name', null, array('id' => 'inputName', 'class' => 'form-control', 'required' => 'required')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="inputNameMy" class="form-label">{{ __('Name (Bahasa)') }}</label>
            {!! Form::text('name_my', null, array('id' => 'inputNameMy', 'class' => 'form-control', 'required' => 'required')) !!}
        </div>
    </div>
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