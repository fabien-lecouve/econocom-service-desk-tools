<x-layouts.dashboard>
    <x-slot:title>
        Modifier une catégorie
    </x-slot:title>

    <div class="category-create" x-data="categorySelector(
        @js($categories),
        @js(old('parent_id', $category->parent_id)),
        @js(old('label', $category->label))
    )">
        <header class="category-create__header">
            <div>
                <nav class="breadcrumb" aria-label="Fil d'Ariane">
                    <a href="{{ route('projects.show', ['project' => $project]) }}">
                        {{ $project->label }}
                    </a>

                    <span>/</span>

                    <a href="{{ route('categories.index', ['project' => $project]) }}">
                        Catégories
                    </a>

                    <span>/</span>

                    <span aria-current="page">
                        Modifier
                    </span>
                </nav>

                <div class="category-create__title-group">
                    <div class="category-create__title-symbol">
                        C
                    </div>

                    <div>
                        <p class="category-create__subtitle">
                            Projet {{ $project->label }}
                        </p>

                        <h1 class="category-create__title">
                            Modifier {{ $category->label }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="category-create__actions">
                <a href="{{ route('categories.index', ['project' => $project]) }}" class="category-create__button">
                    Annuler
                </a>

                <button type="submit" form="category-edit-form"
                    class="category-create__button category-create__button--primary">
                    Enregistrer les modifications
                </button>
            </div>
        </header>

        <div class="category-create__layout">
            <form id="category-edit-form" class="category-form" method="POST"
                action="{{ route('categories.update', [
                    'project' => $project,
                    'category' => $category,
                ]) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <section class="form-section">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Informations générales
                        </h2>

                        <p class="form-section__description">
                            Modifiez le nom et l'emplacement de la catégorie.
                        </p>
                    </div>

                    <div class="form-section__content">
                        <div class="category-form__row">
                            <div class="category-form__group">
                                <label for="project-label" class="category-form__label">
                                    Projet
                                </label>

                                <input id="project-label" class="category-form__input" type="text"
                                    value="{{ $project->label }}" disabled>
                            </div>

                            <div class="category-form__group">
                                <label for="label" class="category-form__label">
                                    Libellé
                                    <span class="category-form__required">*</span>
                                </label>

                                <input id="label"
                                    class="category-form__input @error('label') category-form__input--error @enderror"
                                    type="text" name="label" value="{{ old('label', $category->label) }}"
                                    placeholder="Ex : Gestion des utilisateurs" required x-model="categoryLabel">

                                <p class="category-form__help">
                                    Nom affiché dans la liste des catégories.
                                </p>

                                @error('label')
                                    <p class="category-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>

                <section class="form-section">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Catégorie parente
                        </h2>

                        <p class="form-section__description">
                            Sélectionnez la catégorie dans laquelle cette catégorie
                            doit être placée.
                        </p>
                    </div>

                    <div class="form-section__content">
                        <input type="hidden" name="parent_id" x-model="selectedParentId">

                        <div class="category-form__parents">
                            <template x-for="(level, index) in levels" :key="index">
                                <div class="category-form__group">
                                    <label class="category-form__label"
                                        x-text="index === 0
                                            ? 'Catégorie principale'
                                            : `Sous-catégorie niveau ${index}`"></label>

                                    <select class="category-form__select" x-model="selected[index]"
                                        @change="changeLevel(index)">
                                        <option value="">
                                            Aucune catégorie parente
                                        </option>

                                        <template x-for="item in level" :key="item.id">
                                            <option :value="String(item.id)" x-text="item.label"
                                                :disabled="item.id == {{ $category->id }}"></option>
                                        </template>
                                    </select>
                                </div>
                            </template>
                        </div>

                        @error('parent_id')
                            <p class="category-form__error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </section>
            </form>
        </div>
    </div>
</x-layouts.dashboard>

<script>
    function categorySelector(categories, initialParentId = null, initialLabel = '') {
        return {
            categories: categories ?? [],
            levels: [],
            selected: [],
            selectedParentId: initialParentId !== null
                ? String(initialParentId)
                : '',
            categoryLabel: initialLabel ?? '',

            init() {
                this.levels = [this.categories];

                if (!this.selectedParentId) {
                    return;
                }

                const path = this.findCategoryPath(
                    this.categories,
                    this.selectedParentId
                );

                if (!path) {
                    return;
                }

                this.selected = path.map(category => String(category.id));

                this.levels = [this.categories];

                path.slice(0, -1).forEach(category => {
                    if (category.children?.length) {
                        this.levels.push(category.children);
                    }
                });
            },

            changeLevel(index) {
                this.selected = this.selected.slice(0, index + 1);
                this.levels = this.levels.slice(0, index + 1);

                const selectedId = this.selected[index];

                if (!selectedId) {
                    this.selectedParentId =
                        this.selected[index - 1] ?? '';

                    return;
                }

                const category = this.levels[index].find(
                    item => String(item.id) === String(selectedId)
                );

                this.selectedParentId = String(selectedId);

                if (category?.children?.length) {
                    this.levels.push(category.children);
                }
            },

            findCategoryPath(categories, searchedId, path = []) {
                for (const category of categories) {
                    const currentPath = [...path, category];

                    if (String(category.id) === String(searchedId)) {
                        return currentPath;
                    }

                    if (category.children?.length) {
                        const result = this.findCategoryPath(
                            category.children,
                            searchedId,
                            currentPath
                        );

                        if (result) {
                            return result;
                        }
                    }
                }

                return null;
            }
        };
    }
</script>
