<x-layouts.dashboard>
    <x-slot:title>
        Modifier un message
    </x-slot:title>

    <div
        class="message-create"
        x-data="{
            ...categorySelector(
                @js($categories),
                @js(old('category_id', $message->category_id))
            ),

            label: @js(old('label', $message->label)),
            messageType: @js(old('message_type_id', $message->message_type_id))
        }"
    >
        <header class="message-create__header">
            <div>
                <nav class="breadcrumb" aria-label="Fil d’Ariane">
                    <a href="{{ route('projects.show', ['project' => $project]) }}">
                        {{ $project->label }}
                    </a>

                    <span>/</span>

                    <a href="{{ route('messages.index', ['project' => $project]) }}">
                        Messages
                    </a>

                    <span>/</span>

                    <span aria-current="page">
                        Modifier
                    </span>
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
                            Modifier un message
                        </h1>
                    </div>
                </div>
            </div>

            <div class="message-create__actions">
                <a
                    href="{{ route('messages.index', ['project' => $project]) }}"
                    class="message-create__button"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    form="message-edit-form"
                    class="message-create__button message-create__button--primary"
                >
                    Enregistrer
                </button>
            </div>
        </header>

        <div class="message-create__layout">
            <form
                id="message-edit-form"
                class="message-form"
                method="POST"
                action="{{ route('messages.update', [
                    'project' => $project,
                    'message' => $message,
                ]) }}"
            >
                @csrf
                @method('PUT')

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
                                                    :value="String(category.id)"
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

                                    <span class="message-form__required">
                                        *
                                    </span>
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
                                            @selected(
                                                old(
                                                    'message_type_id',
                                                    $message->message_type_id
                                                ) == $type->id
                                            )
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

                                    <span class="message-form__required">
                                        *
                                    </span>
                                </label>

                                <input
                                    id="label"
                                    class="message-form__input @error('label') message-form__input--error @enderror"
                                    type="text"
                                    name="label"
                                    value="{{ old('label', $message->label) }}"
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
                        </div>
                    </div>
                </section>

                <section class="form-section form-section--translations">
                    <div class="form-section__header">
                        <h2 class="form-section__title">
                            Traductions

                            <span class="message-form__required">
                                *
                            </span>
                        </h2>

                        <p class="form-section__description">
                            Modifiez le contenu du message pour chaque langue
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

                                $translation = $message->translations
                                    ->firstWhere('language_id', $languageId);

                                $fieldName = "translations.$languageId.content";

                                $content = old(
                                    $fieldName,
                                    $translation?->content ?? ''
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
                                    >{{ $content }}</textarea>

                                    <div class="translation-table__counter">
                                        <span
                                            x-data="{ length: @js(mb_strlen($content)) }"
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
        </div>
    </div>
</x-layouts.dashboard>

<script>
    function categorySelector(categories, initialCategoryId = '') {
        return {
            categories: categories ?? [],
            levels: [categories ?? []],
            selected: [],
            selectedCategoryId: initialCategoryId
                ? String(initialCategoryId)
                : '',

            init() {
                if (this.selectedCategoryId) {
                    this.restoreSelection(this.selectedCategoryId);
                }
            },

            changeLevel(index) {
                this.selected = this.selected.slice(0, index + 1);
                this.levels = this.levels.slice(0, index + 1);

                const selectedId = this.selected[index];

                if (!selectedId) {
                    this.selectedCategoryId =
                        this.selected[index - 1] ?? '';

                    return;
                }

                const category = this.findCategory(
                    this.levels[index],
                    selectedId
                );

                this.selectedCategoryId = String(selectedId);

                if (category?.children?.length > 0) {
                    this.levels.push(category.children);
                }
            },

            restoreSelection(categoryId) {
                const path = this.findPath(
                    this.categories,
                    categoryId
                );

                if (!path) {
                    return;
                }

                this.levels = [this.categories];
                this.selected = [];

                path.forEach((category, index) => {
                    this.selected[index] = String(category.id);

                    if (
                        index < path.length - 1 &&
                        category.children?.length > 0
                    ) {
                        this.levels.push(category.children);
                    }
                });

                this.selectedCategoryId = String(categoryId);
            },

            findPath(categories, categoryId, path = []) {
                for (const category of categories) {
                    const currentPath = [...path, category];

                    if (String(category.id) === String(categoryId)) {
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
                return categories.find(
                    category => String(category.id) === String(id)
                );
            }
        };
    }
</script>
