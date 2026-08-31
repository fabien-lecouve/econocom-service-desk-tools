@props([
    'categories',
    'name',
    'type',
    'initialCategoryId' => null
])

<div x-data="categorySelector(
    {{ Js::from($categories) }},
    {{ Js::from($initialCategoryId) }}
)">

    <input type="hidden" name="{{ $name }}" x-model="selectedCategoryId">

    <div class="category-form__parents">

        <template x-for="(level, index) in levels" :key="index">

            <div class="category-form__parent">

                <label
                    :for="'category-' + index"
                    class="form__label"
                    x-text="index === 0
                        ? 'Catégorie'
                        : `Sous-catégorie niveau ${index}`"
                ></label>

                <select
                    :id="'category-' + index"
                    class="form__input"
                    x-model="selected[index]"
                    @change="handleCategoryChange(level, selected[index], index)"
                >

                    @if ($type === 'category')
                        <option value="">
                            Aucune catégorie parente
                        </option>
                    @endif

                    @if ($type === 'message')
                        <option
                            value=""
                            x-text="index === 0
                                ? 'Sélectionnez une catégorie'
                                : 'Aucune sous-catégorie'"
                        ></option>
                    @endif

                    <template x-for="category in level" :key="category.id">
                        <option
                            :value="category.id"
                            x-text="category.label"
                        ></option>
                    </template>

                </select>

            </div>

        </template>

    </div>

    @error($name)
        <p class="category-form__error">
            {{ $message }}
        </p>
    @enderror

</div>
