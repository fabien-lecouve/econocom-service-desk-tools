@props([
    'name',
    'options' => [],
    'value' => []
])

<div class="form__group form__group--row">

    @foreach ($options as $key => $label)
        <div class="form__checkbox">
            <input
                {{ $attributes->merge(['class' => 'form__checkbox-input']) }}
                id="{{ $name }}_{{ $key }}"
                type="checkbox"
                name="{{ $name }}[]"
                value="{{ $key }}"
                @checked(in_array($key, old($name, (array) $value)))
            >

            <label class="form__checkbox-label" for="{{ $name }}_{{ $key }}">
                {{ ucfirst($label) }}
            </label>
        </div>
    @endforeach

    @error($name)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>
