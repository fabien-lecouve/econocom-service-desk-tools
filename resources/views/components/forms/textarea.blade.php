@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
])

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
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>
