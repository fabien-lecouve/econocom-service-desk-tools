<x-layouts.dashboard>
    <x-slot:title>
        Créer une catégorie
    </x-slot:title>

    <div
        class="category-create"
        x-data="{
            categoryLabel: '',
            ...categorySelector(@js($categories))
        }"
    >
        <header class="category-create__header">
            <div>
                <nav class="breadcrumb" aria-label="Fil d'Ariane">
                    <a href="{{ route('projects.show', ['project' => $project]) }}">
                        {{ $project->label }}
                    </a>

                    <span>/</span>

                    <span>Catégories</span>

                    <span>/</span>

                    <span aria-current="page">Créer</span>
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
                            Créer une catégorie
                        </h1>
                    </div>
                </div>
            </div>

            <div class="category-create__actions">
                <a
                    href="{{ url()->previous() }}"
                    class="category-create__button"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    form="category-create-form"
                    class="category-create__button category-create__button--primary"
                >
                    Enregistrer
                </button>
            </div>
        </header>

        <div class="category-create__layout">
            <form
                id="category-create-form"
                class="category-form"
                method="POST"
                action="{{ route('categories.store') }}"
            >
                @csrf

                <input
                    type="hidden"
                    name="project_id"
                    value="{{ $project->id }}"
                >

                <section class="form-section">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Informations générales
                        </h2>

                        <p class="form-section__description">
                            Définissez le nom et l'emplacement de la catégorie.
                        </p>
                    </div>

                    <div class="form-section__content">
                        <div class="category-form__row">
                            <div class="category-form__group">
                                <label
                                    for="project-label"
                                    class="category-form__label"
                                >
                                    Projet
                                </label>

                                <input
                                    id="project-label"
                                    class="category-form__input"
                                    type="text"
                                    value="{{ $project->label }}"
                                    disabled
                                >
                            </div>

                            <div class="category-form__group">
                                <label
                                    for="label"
                                    class="category-form__label"
                                >
                                    Libellé
                                    <span class="category-form__required">*</span>
                                </label>

                                <input
                                    id="label"
                                    class="category-form__input @error('label') category-form__input--error @enderror"
                                    type="text"
                                    name="label"
                                    value="{{ old('label') }}"
                                    placeholder="Ex : Gestion des utilisateurs"
                                    required
                                    x-model="categoryLabel"
                                >

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
                            Sélectionnez une catégorie existante pour créer une
                            sous-catégorie.
                        </p>
                    </div>

                    <div class="form-section__content">
                        <input
                            type="hidden"
                            name="parent_id"
                            x-model="selectedParentId"
                        >

                        <div class="category-form__parents">
                            <template
                                x-for="(level, index) in levels"
                                :key="index"
                            >
                                <div class="category-form__group">
                                    <label
                                        class="category-form__label"
                                        x-text="index === 0
                                            ? 'Catégorie principale'
                                            : `Sous-catégorie niveau ${index}`"
                                    ></label>

                                    <select
                                        class="category-form__select"
                                        x-model="selected[index]"
                                        @change="changeLevel(index)"
                                    >
                                        <option value="">
                                            Aucune catégorie parente
                                        </option>

                                        <template
                                            x-for="category in level"
                                            :key="category.id"
                                        >
                                            <option
                                                :value="category.id"
                                                x-text="category.label"
                                            ></option>
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

                {{-- <section class="form-section">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Apparence
                            <span class="form-section__optional">
                                facultatif
                            </span>
                        </h2>

                        <p class="form-section__description">
                            Personnalisez l'affichage de la catégorie.
                        </p>
                    </div>

                    <div class="form-section__content">
                        <div class="category-form__row category-form__row--three">
                            <div class="category-form__group">
                                <label
                                    for="font-color"
                                    class="category-form__label"
                                >
                                    Couleur du texte
                                </label>

                                <select
                                    id="font-color"
                                    class="category-form__select"
                                    name="font_color_id"
                                >
                                    <option value="">
                                        Couleur par défaut
                                    </option>

                                    Options fictives à remplacer par $colors
                                    <option value="1">Noir</option>
                                    <option value="2">Violet</option>
                                    <option value="3">Bleu</option>
                                </select>
                            </div>

                            <div class="category-form__group">
                                <label
                                    for="background-color"
                                    class="category-form__label"
                                >
                                    Couleur de fond
                                </label>

                                <select
                                    id="background-color"
                                    class="category-form__select"
                                    name="background_color_id"
                                >
                                    <option value="">
                                        Couleur par défaut
                                    </option>

                                    Options fictives à remplacer par $colors
                                    <option value="1">Blanc</option>
                                    <option value="2">Violet clair</option>
                                    <option value="3">Bleu clair</option>
                                </select>
                            </div>

                            <div class="category-form__group">
                                <label
                                    for="border-color"
                                    class="category-form__label"
                                >
                                    Bordure supérieure
                                </label>

                                <select
                                    id="border-color"
                                    class="category-form__select"
                                    name="border_top_color_id"
                                >
                                    <option value="">
                                        Couleur par défaut
                                    </option>

                                    Options fictives à remplacer par $colors
                                    <option value="1">Gris</option>
                                    <option value="2">Violet</option>
                                    <option value="3">Bleu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section> --}}

                {{-- <section class="form-section">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Ordre d'affichage
                        </h2>

                        <p class="form-section__description">
                            Les catégories ayant la position la plus basse
                            apparaissent en premier.
                        </p>
                    </div>

                    <div class="form-section__content">
                        <div class="category-form__group category-form__group--small">
                            <label
                                for="position"
                                class="category-form__label"
                            >
                                Position
                            </label>

                            <input
                                id="position"
                                class="category-form__input"
                                type="number"
                                name="position"
                                value="{{ old('position', 1) }}"
                                min="0"
                            >
                        </div>
                    </div>
                </section> --}}
            </form>

            {{-- <aside class="category-preview">
                <h2 class="category-preview__title">
                    Aperçu de la catégorie
                </h2>

                <div class="category-preview__card">
                    <div class="category-preview__top-line"></div>

                    <div class="category-preview__content">
                        <p
                            class="category-preview__label"
                            x-text="categoryLabel || 'Libellé de la catégorie'"
                        ></p>

                        <span class="category-preview__counter">
                            0 message
                        </span>
                    </div>

                    <p class="category-preview__description">
                        Les messages associés à cette catégorie apparaîtront
                        dans cette zone.
                    </p>
                </div>

                <div class="category-preview__information">
                    <h3>Organisation</h3>

                    <p>
                        Une catégorie sans parent sera affichée au premier
                        niveau.
                    </p>

                    <p>
                        La sélection d'un parent permet de créer plusieurs
                        niveaux de sous-catégories.
                    </p>
                </div>
            </aside> --}}
        </div>
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
