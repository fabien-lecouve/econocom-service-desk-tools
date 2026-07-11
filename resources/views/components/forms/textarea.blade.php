@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
])

@php
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
@endphp

<div class="form__group">
    <label class="form__label" for="{{ $name }}">
        {{ $label }}

        @if($required)
            <span class="required_field">*</span>
        @endif
    </label>

    <textarea
        {{ $attributes->merge(['class' => 'form__input']) }}
        id="{{ $name }}"
        name="{{ $name }}"
    >{{ old($errorKey, $value) }}</textarea>

    @error($errorKey)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>
