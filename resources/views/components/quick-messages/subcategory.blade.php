<div class="card">
    <h3 class="card__title" x-text="subcategory.label"></h3>
    <div class="card__content">

        <template x-if="subcategory.messages.length">
            <div class="group__content">
                <x-quick-messages.message source="subcategory" />
            </div>
        </template>

        <template x-for="child in subcategory.children" :key="'subcategory-' + child.category_id">
            <div x-data="{ group: child }">
                <x-quick-messages.group />
            </div>
        </template>
    </div>
</div>
