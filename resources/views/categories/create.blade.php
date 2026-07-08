<x-layouts.dashboard>
    <x-slot:title>
        Créer une catégorie
    </x-slot:title>

    <div class="main__content">
        <form class="form" method="POST" action="{{ route('categories.store') }}">
            @csrf

            <x-forms.input name="project_id" :value="$project->id" type="hidden" />

            <div x-data="categorySelector(@js($categories))">
                <input type="hidden" name="parent_id" x-model="selectedParentId">

                <template x-for="(level, index) in levels" :key="index">
                    <div class="form__group">
                        <label class="form__label">Parent</label>

                        <select class="form__input" x-model="selected[index]" @change="changeLevel(index)">
                            <option value="">Aucun</option>

                            <template x-for="category in level" :key="category.id">
                                <option :value="category.id" x-text="category.label"></option>
                            </template>
                        </select>
                    </div>
                </template>
            </div>

            <x-forms.input name="label" label="Libellé" required />

            <x-forms.submit label="Créer" />
        </form>
    </div>

</x-layouts.dashboard>

<script>
function categorySelector(categories) {
    return {
        categories: categories,
        levels: [categories],
        selected: [],
        selectedParentId: '',

        changeLevel(index) {
            this.selected = this.selected.slice(0, index + 1);
            this.levels = this.levels.slice(0, index + 1);

            const selectedId = this.selected[index];

            if (!selectedId) {
                this.selectedParentId = this.selected[index - 1] ?? '';
                return;
            }

            const category = this.findCategory(this.levels[index], selectedId);

            this.selectedParentId = selectedId;

            if (category && category.children.length > 0) {
                this.levels.push(category.children);
            }
        },

        findCategory(categories, id) {
            return categories.find(category => category.id == id);
        }
    }
}
</script>
