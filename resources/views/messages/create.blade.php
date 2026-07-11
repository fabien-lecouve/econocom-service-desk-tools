<x-layouts.dashboard>
    <x-slot:title>
        Créer un message
    </x-slot:title>

    <div class="main__content">
        <form class="form" method="POST" action="{{ route('messages.store') }}">
            @csrf

            <x-forms.input name="project_id" :value="$project->id" type="hidden" />

            <div x-data="categorySelector(
                @js($categories),
                @js(old('category_id'))
            )">
                <input type="hidden" name="category_id" x-model="selectedCategoryId">

                <template x-for="(level, index) in levels" :key="index">
                    <div class="form__group">
                        <label class="form__label">Catégorie</label>

                        <select class="form__input" x-model="selected[index]" @change="changeLevel(index)">
                            <option value="">Aucun</option>

                            <template x-for="category in level" :key="category.id">
                                <option :value="category.id" x-text="category.label"></option>
                            </template>
                        </select>
                    </div>
                </template>

                @error('category_id')
                    <div class="form__error">{{ $message }}</div>
                @enderror
            </div>

            <x-forms.input name="label" label="Libellé" required />

            <x-forms.select name="message_type_id" label="Type de message" :options="$types" required />

            @foreach ($project->projectLanguageSettings as $setting)
                <x-forms.input name="translations[{{ $setting->language->id }}][language_id]" :value="$setting->language->id"
                    type="hidden" />

                <x-forms.textarea name="translations[{{ $setting->language->id }}][content]"
                    label="Contenu {{ strtoupper($setting->language->code) }}" rows="8" required />
            @endforeach


            <x-forms.submit label="Créer" />
        </form>
    </div>

</x-layouts.dashboard>

<script>
    function categorySelector(categories, oldCategoryId = '') {
        return {
            categories,
            levels: [categories],
            selected: [],
            selectedCategoryId: oldCategoryId,

            init() {
                if (oldCategoryId) {
                    this.restoreSelection(oldCategoryId);
                }
            },

            changeLevel(index) {
                this.selected = this.selected.slice(0, index + 1);
                this.levels = this.levels.slice(0, index + 1);

                const selectedId = this.selected[index];

                if (!selectedId) {
                    this.selectedCategoryId = this.selected[index - 1] ?? '';
                    return;
                }

                const category = this.findCategory(
                    this.levels[index],
                    selectedId
                );

                this.selectedCategoryId = selectedId;

                if (category?.children?.length > 0) {
                    this.levels.push(category.children);
                }
            },

            restoreSelection(categoryId) {
                const path = this.findPath(this.categories, categoryId);

                if (!path) {
                    return;
                }

                this.levels = [this.categories];
                this.selected = [];

                path.forEach((category, index) => {
                    this.selected[index] = String(category.id);

                    if (category.children?.length > 0) {
                        this.levels.push(category.children);
                    }
                });

                this.selectedCategoryId = String(categoryId);
            },

            findPath(categories, categoryId, path = []) {
                for (const category of categories) {
                    const currentPath = [...path, category];

                    if (category.id == categoryId) {
                        return currentPath;
                    }

                    if (category.children?.length > 0) {
                        const result = this.findPath(
                            category.children,
                            categoryId,
                            currentPath
                        );

                        if (result) {
                            return result;
                        }
                    }
                }

                return null;
            },

            findCategory(categories, id) {
                return categories.find(category => category.id == id);
            }
        }
    }
</script>
