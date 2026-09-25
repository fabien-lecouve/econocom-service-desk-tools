@props([
    'name',
    'label',
    'value' => false,
])

<div class="form__group form__group--row">
    <div class="form__checkbox">

        <input type="hidden" name="{{ $name }}" value="0">

        <input
            {{ $attributes->merge(['class' => 'form__checkbox-input']) }}
            id="{{ $name }}"
            type="checkbox"
            name="{{ $name }}"
            value="1"
            @checked(old($name, $value))
        >

        <label class="form__checkbox-label" for="{{ $name }}">
            {{ ucfirst($label) }}
        </label>

    </div>

    @error($name)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>
