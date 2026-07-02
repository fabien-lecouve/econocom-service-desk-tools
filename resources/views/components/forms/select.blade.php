@props([
    'name',
    'label',
    'options' => [],
    'value' => '',
    'required' => false,
    'placeholder' => 'Sélectionner une option',
])

<div class="form__group">
    <label class="form__label" for="{{ $name }}">
        {{ $label }}

        @if($required)
            <span class="required_field">*</span>
        @endif
    </label>

    <select
        {{ $attributes->merge(['class' => 'form__input']) }}
        id="{{ $name }}"
        name="{{ $name }}"
    >
        <option value="">
            {{ $placeholder }}
        </option>

        @foreach($options as $option)
            <option
                value="{{ $option->id }}"
                @selected(old($name, $value) == $option->id)
            >
                {{ $option->name }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="form__error">{{ $message }}</div>
    @enderror
</div>