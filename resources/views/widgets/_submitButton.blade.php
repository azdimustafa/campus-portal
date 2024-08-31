<button class="{{ config('adminlte.btn_primary') }}" type="submit" name="submit" value="submit">
    @if(isset($isUpdate))
        {{ __($label ?? 'Update') }}
    @else
        {{ __($label ?? 'Save') }}
    @endif
</button>