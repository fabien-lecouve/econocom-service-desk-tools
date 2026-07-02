@props([
    'name',
    'label',
    'type' => 'text',
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

    <input
        {{ $attributes->merge(['class' => 'form__input']) }}
        id="{{ $name }}"
        type="{{ $type }}"
        name="{{ $name }}"
        @if($type !== 'file')
        value="{{ old($name, $value) }}"
        @endif
    >

    @error($name)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>