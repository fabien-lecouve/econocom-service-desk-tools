@props([
    'name',
    'legend',
    'options' => [],
    'required' => false,
])

<div class="form__group">
    <fieldset>
        <legend>
            {{ $legend }}

            @if($required)
                <span class="required_field">*</span>
            @endif
        </legend>

        @foreach ($options as $key => $value)
            <div class="form__checkbox">
                <input
                    {{ $attributes->merge(['class' => 'form__checkbox-input']) }}
                    id="{{ $name }}_{{ $key }}"
                    type="checkbox"
                    name="{{ $name }}[]"
                    value="{{ $key }}"
                    @checked(in_array($key, old($name, [])))
                >

                <label class="form__checkbox-label" for="{{ $name }}_{{ $key }}">
                    {{ $value }}
                </label>
            </div>
        @endforeach
    </fieldset>

    @error($name)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>
