@props([
    'name',
    'label',
    'options' => [],
    'value' => '',
    'required' => false,
    'placeholder' => '',
])

<div class="form__group">
    <label class="form__label" for="{{ $name }}">
        {{ $label }}

        @if($required)
            <span class="required_field">*</span>
        @endif
    </label>

    @php
        $fieldName = str_replace(['[', ']'], ['.', ''], $name);
    @endphp

    <select
        {{ $attributes->merge(['class' => 'form__input']) }}
        id="{{ $name }}"
        name="{{ $name }}"
    >
        @if ($placeholder)
            <option value="">
                {{ $placeholder }}
            </option>
        @endif

        @foreach($options as $option)
            <option
                value="{{ $option['id'] }}"
                @selected(old($fieldName, $value) == $option['id'])
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>

    @error($fieldName)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>
