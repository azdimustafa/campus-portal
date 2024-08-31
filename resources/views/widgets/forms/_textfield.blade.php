@if ($type == 'email')
{{ Form::email($name, old($name, $defaultValue ?? ''), [
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'placeholder' => __($placeholder ?? ''),
    'id' => $id ?? 'input-' . $name,
    'required' => $required ?? false,
    'maxlength' => $maxlength ?? 255,
]) }}
@elseif ($type == 'password')
{{ Form::password($name, [
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'placeholder' => __($placeholder ?? ''),
    'id' => $id ?? 'input-' . $name,
    'required' => $required ?? false,
    'maxlength' => $maxlength ?? 255,
]) }}
@elseif ($type == 'number')
{{ Form::number($name, old($name, $defaultValue ?? ''), [
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'placeholder' => __($placeholder ?? ''),
    'id' => $id ?? 'input-' . $name,
    'required' => $required ?? false,
    'maxlength' => $maxlength ?? 255,
]) }}
@else
{{ Form::text($name, old($name, $defaultValue ?? ''), [
    'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
    'placeholder' => __($placeholder ?? ''),
    'id' => $id ?? 'input-' . $name,
    'required' => $required ?? false,
    'maxlength' => $maxlength ?? 255,
]) }}
@endif
@error($name)
<div class="invalid-feedback">{{ $errors->first($name) }}</div>
@enderror
@isset($hint) <small id="emailHelp" class="form-text text-muted">{{ __($hint) }}</small> @endisset