<div class="icheck-primary">
    {!! Form::checkbox($name, $check_value ?? null, null, ['id' => $id, 'required' => $required ?? false]) !!}
    <label for="{{ $id }}" class="form-check-label">{{ __( $label ?? 'On') }}</label>
</div> 

@error($name)
<div class="invalid-feedback">{{ $errors->first($name) }}</div>
@enderror