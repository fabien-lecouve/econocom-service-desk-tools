@props(['label', 'type' => 'text'])

<div class="form__actions">
    <div>
        <span class="required_field">*</span>
        <small>champs requis</small>
    </div>
    <button class="btn" type="{{ $type }}">
        {{ $label }}
    </button>
</div>
