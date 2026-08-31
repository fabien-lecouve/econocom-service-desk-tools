@props([
    'name',
    'value' => '',
])

<input
    {{ $attributes }}
    type="hidden"
    id="{{ $name }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
>
