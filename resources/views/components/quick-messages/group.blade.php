<div class="group">
    <h4 class="group__title" x-text="group.label"></h4>
    <div class="group__content">

        <template x-if="group.messages.length">
                <x-quick-messages.message source="group" />
        </template>

    </div>
</div>
