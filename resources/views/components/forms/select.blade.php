@props([
    'name' => null,
    'label',
    'options' => [],
    'value' => '',
    'required' => false,
    'placeholder' => '',
])

<div class="form__group">
    <label
        class="form__label"
        @if($name) for="{{ $name }}" @endif
    >
        {{ $label }}

        @if($required)
            <span class="required_field">*</span>
        @endif
    </label>

    @php
        $fieldName = $name
            ? str_replace(['[', ']'], ['.', ''], $name)
            : null;
    @endphp

    <select
        {{ $attributes->merge(['class' => 'form__input']) }}
        @if($name)
            id="{{ $name }}"
            name="{{ $name }}"
        @endif
    >
        @if ($placeholder)
            <option value="">
                {{ $placeholder }}
            </option>
        @endif

        @foreach($options as $option)
            <option
                value="{{ $option['id'] }}"
                @selected($fieldName && old($fieldName, $value) == $option['id'])
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>

    @if($fieldName)
        @error($fieldName)
            <div class="form__error">{{ $message }}</div>
        @enderror
    @endif
</div>
