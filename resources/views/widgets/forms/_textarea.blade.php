{{ Form::textarea($name, old($name, $defaultValue ?? ''), [
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'placeholder' => __($placeholder ?? ''),
    'id' => $id ?? 'input-' . $name,
    'required' => $required ?? false,
    'rows' => $rows ?? 3,
]) }}

@error($name)
<div class="invalid-feedback">{{ $errors->first($name) }}</div>
@enderror
@isset($hint) <small id="emailHelp" class="form-text text-muted">{{ __($hint) }}</small> @endisset