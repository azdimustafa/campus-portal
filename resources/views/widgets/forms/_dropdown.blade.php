{{ Form::select($name, $items, old($name, $defaultValue ?? ''), [
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'placeholder' => __($placeholder ?? '- Please choose -'),
    'id' => $id ?? 'input-' . $name,
    'required' => $required ?? false,
    'style' => 'width: 100%',
]) }}

@error($name)
<div class="invalid-feedback">{{ $errors->first($name) }}</div>
@enderror
@isset($hint) <small id="emailHelp" class="form-text text-muted">{{ __($hint) }}</small> @endisset