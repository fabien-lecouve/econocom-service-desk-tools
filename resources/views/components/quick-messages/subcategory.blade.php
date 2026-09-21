@props(['source'])

<template x-if="{{ $source }}.children.length">
    <template x-for="subcategory in {{ $source }}.children" :key="'subcategory-' + subcategory.code">
        <div class="category-child">

            <template x-if="subcategory.messages.length">
                <x-quick-messages.group source="subcategory" />
            </template>

            <template x-if="subcategory.children.length">
                <div
                    class="subcategory"
                    :style="getCategoryStyle(subcategory)">
                    <h3 class="subcategory__title" x-text="subcategory.label">
                    </h3>

                    <div class="subcategory__content">
                        <template x-for="group in subcategory.children" :key="'group-' + group.code">
                            <x-quick-messages.group source="group" />
                        </template>
                    </div>
                </div>
            </template>

        </div>
    </template>
</template>
