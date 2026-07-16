<x-layouts.dashboard>
    <x-slot:title>
        Créer un message
    </x-slot:title>

    <div
        class="message-create"
        x-data="{
            ...categorySelector(
                @js($categories),
                @js(old('category_id'))
            ),

            label: @js(old('label', '')),
            shortcut: @js(old('shortcut', '')),
            messageType: @js(old('message_type_id', '')),
            previewContent: '',

            updatePreviewContent(event) {
                if (!this.previewContent || event.target.value) {
                    this.previewContent = event.target.value;
                }
            }
        }"
    >
        <header class="message-create__header">
            <div>
                <nav class="breadcrumb" aria-label="Fil d’Ariane">
                    <a href="{{ route('projects.show', ['project' => $project]) }}">
                        {{ $project->label }}
                    </a>

                    <span>/</span>

                    <span>Messages</span>

                    <span>/</span>

                    <span aria-current="page">Créer</span>
                </nav>

                <div class="message-create__title-group">
                    <div class="message-create__title-symbol">
                        M
                    </div>

                    <div>
                        <p class="message-create__subtitle">
                            Projet {{ $project->label }}
                        </p>

                        <h1 class="message-create__title">
                            Créer un message
                        </h1>
                    </div>
                </div>
            </div>

            <div class="message-create__actions">
                <a
                    href="{{ url()->previous() }}"
                    class="message-create__button"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    form="message-create-form"
                    class="message-create__button message-create__button--primary"
                >
                    Enregistrer
                </button>
            </div>
        </header>

        <div class="message-create__layout">
            <form
                id="message-create-form"
                class="message-form"
                method="POST"
                action="{{ route('messages.store') }}"
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
                    </div>

                    <div class="form-section__content">
                        <div class="message-form__row message-form__row--three">
                            <div class="message-form__group">
                                <label
                                    for="project-label"
                                    class="message-form__label"
                                >
                                    Projet
                                </label>

                                <input
                                    id="project-label"
                                    class="message-form__input"
                                    type="text"
                                    value="{{ $project->label }}"
                                    disabled
                                >
                            </div>

                            <div class="message-form__group">
                                <input
                                    type="hidden"
                                    name="category_id"
                                    x-model="selectedCategoryId"
                                >

                                <template
                                    x-for="(level, index) in levels"
                                    :key="index"
                                >
                                    <div class="message-form__group">
                                        <label
                                            class="message-form__label"
                                            x-text="index === 0
                                                ? 'Catégorie'
                                                : `Sous-catégorie niveau ${index}`"
                                        ></label>

                                        <select
                                            class="message-form__select"
                                            x-model="selected[index]"
                                            @change="changeLevel(index)"
                                        >
                                            <option value="">
                                                Sélectionner une catégorie
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

                                @error('category_id')
                                    <p class="message-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="message-form__group">
                                <label
                                    for="message-type"
                                    class="message-form__label"
                                >
                                    Type de message
                                    <span class="message-form__required">*</span>
                                </label>

                                <select
                                    id="message-type"
                                    class="message-form__select @error('message_type_id') message-form__input--error @enderror"
                                    name="message_type_id"
                                    required
                                    x-model="messageType"
                                >
                                    <option value="">
                                        Sélectionner un type de message
                                    </option>

                                    @foreach ($types as $type)
                                        <option
                                            value="{{ $type->id }}"
                                            @selected(old('message_type_id') == $type->id)
                                        >
                                            {{ $type->label }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('message_type_id')
                                    <p class="message-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
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
                    </div>

                    <div class="form-section__content">
                        <div class="message-form__row message-form__row--three">
                            <div class="message-form__group">
                                <label
                                    for="font-color"
                                    class="message-form__label"
                                >
                                    Couleur du texte
                                </label>

                                <select
                                    id="font-color"
                                    class="message-form__select"
                                    name="font_color_id"
                                >
                                    <option value="">
                                        Couleur par défaut
                                    </option>

                                    @isset($colors)
                                        @foreach ($colors as $key => $color)
                                            <option
                                                value="{{ $key }}"
                                                @selected(old('font_color_id') == $key)
                                            >
                                                {{ $color }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>

                                @error('font_color_id')
                                    <p class="message-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="message-form__group">
                                <label
                                    for="background-color"
                                    class="message-form__label"
                                >
                                    Couleur de fond
                                </label>

                                <select
                                    id="background-color"
                                    class="message-form__select"
                                    name="background_color_id"
                                >
                                    <option value="">
                                        Couleur par défaut
                                    </option>

                                    @isset($colors)
                                        @foreach ($colors as $key => $color)
                                            <option
                                                value="{{ $key }}"
                                                @selected(old('background_color_id') == $key)
                                            >
                                                {{ $color }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>

                                @error('background_color_id')
                                    <p class="message-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="message-form__group">
                                <label
                                    for="border-color"
                                    class="message-form__label"
                                >
                                    Couleur de bordure supérieure
                                </label>

                                <select
                                    id="border-color"
                                    class="message-form__select"
                                    name="border_top_color_id"
                                >
                                    <option value="">
                                        Couleur par défaut
                                    </option>

                                    @isset($colors)
                                        @foreach ($colors as $key => $color)
                                            <option
                                                value="{{ $key }}"
                                                @selected(old('border_top_color_id') == $key)
                                            >
                                                {{ $color }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>

                                @error('border_top_color_id')
                                    <p class="message-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section> --}}

                <section class="form-section">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Informations du message
                        </h2>
                    </div>

                    <div class="form-section__content">
                        <div class="message-form__row">
                            <div class="message-form__group">
                                <label
                                    for="label"
                                    class="message-form__label"
                                >
                                    Libellé
                                    <span class="message-form__required">*</span>
                                </label>

                                <input
                                    id="label"
                                    class="message-form__input @error('label') message-form__input--error @enderror"
                                    type="text"
                                    name="label"
                                    value="{{ old('label') }}"
                                    placeholder="Ex : Réinitialisation de mot de passe"
                                    required
                                    x-model="label"
                                >

                                <p class="message-form__help">
                                    Nom affiché dans la liste des messages.
                                </p>

                                @error('label')
                                    <p class="message-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- <div class="message-form__group">
                                <label
                                    for="shortcut"
                                    class="message-form__label"
                                >
                                    Raccourci clavier
                                    <span class="message-form__optional">
                                        facultatif
                                    </span>
                                </label>

                                <input
                                    id="shortcut"
                                    class="message-form__input @error('shortcut') message-form__input--error @enderror"
                                    type="text"
                                    name="shortcut"
                                    value="{{ old('shortcut') }}"
                                    placeholder="Ex : P"
                                    maxlength="1"
                                    x-model="shortcut"
                                >

                                <div class="message-form__help-row">
                                    <p class="message-form__help">
                                        Une seule lettre.
                                    </p>

                                    <span
                                        class="message-form__counter"
                                        x-text="`${shortcut.length} / 1`"
                                    ></span>
                                </div>

                                @error('shortcut')
                                    <p class="message-form__error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div> --}}
                        </div>

                        {{-- <div class="message-form__group message-form__group--small">
                            <label
                                for="position"
                                class="message-form__label"
                            >
                                Position
                                <span class="message-form__optional">
                                    facultatif
                                </span>
                            </label>

                            <input
                                id="position"
                                class="message-form__input"
                                type="number"
                                name="position"
                                value="{{ old('position', 1) }}"
                                min="0"
                            >

                            <p class="message-form__help">
                                Plus le chiffre est petit, plus le message apparaît haut.
                            </p>

                            @error('position')
                                <p class="message-form__error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div> --}}
                    </div>
                </section>

                <section class="form-section form-section--translations">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Traductions
                            <span class="message-form__required">*</span>
                        </h2>

                        <p class="form-section__description">
                            Ajoutez le contenu du message pour chaque langue
                            activée sur ce projet.
                        </p>
                    </div>

                    <div class="translation-table">
                        <div class="translation-table__header">
                            <div>Langue</div>
                            <div>Contenu du message</div>
                        </div>

                        @foreach ($project->projectLanguageSettings as $setting)
                            @php
                                $languageId = $setting->language->id;
                                $fieldName = "translations.$languageId.content";
                                $oldContent = old(
                                    "translations.$languageId.content",
                                    ''
                                );
                            @endphp

                            <div class="translation-table__row">
                                <div class="translation-table__language">
                                    <span class="translation-table__language-code">
                                        {{ strtoupper($setting->language->code) }}
                                    </span>

                                    <span>
                                        {{ $setting->language->label }}
                                    </span>
                                </div>

                                <div class="translation-table__content">
                                    <input
                                        type="hidden"
                                        name="translations[{{ $languageId }}][language_id]"
                                        value="{{ $languageId }}"
                                    >

                                    <textarea
                                        id="translation-{{ $languageId }}"
                                        class="translation-table__textarea @error($fieldName) translation-table__textarea--error @enderror"
                                        name="translations[{{ $languageId }}][content]"
                                        rows="5"
                                        maxlength="5000"
                                        placeholder="Saisir le contenu du message en {{ strtolower($setting->language->label) }}..."
                                        required
                                        @input="updatePreviewContent($event)"
                                    >{{ $oldContent }}</textarea>

                                    <div class="translation-table__counter">
                                        <span
                                            x-data="{ length: @js(strlen($oldContent)) }"
                                            @input.window="
                                                if ($event.target.id === 'translation-{{ $languageId }}') {
                                                    length = $event.target.value.length
                                                }
                                            "
                                            x-text="`${length} / 5000`"
                                        ></span>
                                    </div>

                                    @error($fieldName)
                                        <p class="message-form__error">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('translations')
                        <p class="message-form__error">
                            {{ $message }}
                        </p>
                    @enderror
                </section>
            </form>

            {{-- <aside class="message-preview">
                <h2 class="message-preview__title">
                    Aperçu du message
                </h2>

                <div class="message-preview__card">
                    <div class="message-preview__heading">
                        <p
                            class="message-preview__label"
                            x-text="label || 'Libellé du message'"
                        ></p>

                        <span
                            class="message-preview__shortcut"
                            x-text="shortcut || '—'"
                        ></span>
                    </div>

                    <div class="message-preview__top-line"></div>

                    <div class="message-preview__information">
                        <p
                            class="message-preview__type"
                            x-text="messageType
                                ? 'Type de message sélectionné'
                                : 'Type de message'"
                        ></p>

                        <p class="message-preview__category">
                            Catégorie / Sous-catégorie
                        </p>
                    </div>

                    <div class="message-preview__content">
                        <p
                            x-show="previewContent"
                            x-text="previewContent"
                        ></p>

                        <p x-show="!previewContent">
                            Le contenu du message sélectionné sera affiché ici.
                        </p>
                    </div>
                </div>

                <p class="message-preview__notice">
                    L’aperçu reflète le libellé, le raccourci et le contenu
                    saisis dans le formulaire.
                </p>
            </aside> --}}
        </div>
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
