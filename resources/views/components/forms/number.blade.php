@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'min' => null,
    'max' => null,
    'step' => 1,
])

<div class="form__group">
    <label class="form__label" for="{{ $name }}">
        {{ $label }}

        @if ($required)
            <span class="required_field">*</span>
        @endif
    </label>

    <input
        {{ $attributes->class(['form__input']) }}
        id="{{ $name }}"
        type="number"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if (!is_null($min)) min="{{ $min }}" @endif
        @if (!is_null($max)) max="{{ $max }}" @endif
        step="{{ $step }}"
    >

    @error($name)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>
