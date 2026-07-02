<section :id="category.id" class="section">
    <h2 class="section__title" x-text="category.label"></h2>
    <div class="section__content">

        <template x-if="category.messages.length">
            <x-quick-messages.message source="category" />
        </template>

        <template x-for="child in category.children" :key="'subcategory-' + child.category_id">
            <div x-data="{ subcategory: child }">
                <x-quick-messages.subcategory />
            </div>
        </template>

    </div>
</section>
