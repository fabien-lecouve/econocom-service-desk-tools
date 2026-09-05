@props(['source'])

<div class="group">
    <h4 class="group__title" x-text="{{ $source}}.label"></h4>
    <div class="group__content">

        <template x-if="{{ $source}}.messages.length">
            <x-quick-messages.message :source="$source" />
        </template>

    </div>
</div>
