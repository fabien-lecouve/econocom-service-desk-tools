<section
    :id="category.id"
    class="category"
    :style="getCategoryStyle(category)">
    <h2 class="category__title" x-text="category.label"></h2>
    <div class="category__content">

        <template x-if="category.messages.length">
            <x-quick-messages.message source="category" />
        </template>

        <template x-if="category.children.length">
            <x-quick-messages.subcategory source="category" />
        </template>

    </div>
</section>
