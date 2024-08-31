@foreach ($list as $key => $val)
    <div class="icheck-primary">
        {!! Form::radio($name, $key ?? null, null, ['id' => $id.'_'.$key, 'required' => $required ?? false]) !!}
        <label for="{{ $id.'_'.$key }}" class="form-check-label">{{ __( $val) }}</label>
    </div> 
@endforeach

@error($name)
<div class="invalid-feedback">{{ $errors->first($name) }}</div>
@enderror