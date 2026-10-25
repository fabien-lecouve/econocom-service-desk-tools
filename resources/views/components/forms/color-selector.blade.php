@props([
    'name' => null,
    'label',
    'colors',
    'value' => null,
    'required' => false,
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

    <div 
        {{ $attributes }}
        x-data="colorSelector(
            {{ Js::from($colors) }},
            {{ Js::from(old($name, $value)) }}
        )"
        x-modelable="selectedColorId"
        @click.outside="close()"
        class="form__color-selector"
    >

        <input type="hidden" name="{{ $name }}" x-model="selectedColorId">

        <button 
            x-ref="button"
            type="button"
            class="form__input form__color-selector-button"
            @click="toggle"
        >
            
            <span x-text="selectedColor?.label ?? 'Choisissez une couleur'"></span>

            <template x-if="!selectedColor">
                <i class="fa-solid fa-chevron-down"></i>
            </template>
            <template x-if="selectedColor">
                <span 
                    class="form__color-selector-hex"
                    :style="{background: selectedColor.hex}">
                </span>
            </template>
        </button>

        <ul 
            x-show="open"
            class="form__color-selector-list"
            :class="{ 'open-up': openUp }"
        >
            <template x-if="selectedColor">
                <li 
                    class="form__color-selector-item"
                    @click="selectColor(null)"
                    >
                    <span>Choisissez une couleur</span>
                </li>
            </template>
            <template x-for="color in colors" :key="color.id">
                <li 
                    class="form__color-selector-item"
                    @click="selectColor(color.id)"
                >
                    <span x-text="color.label"></span>
                    <span 
                        class="form__color-selector-hex"
                        :style="{background: color.hex}">
                    </span>
                </li>
            </template>
        </ul>
    </div>

    @if($name)
        @error($name)
            <div class="form__error">{{ $message }}</div>
        @enderror
    @endif
</div>