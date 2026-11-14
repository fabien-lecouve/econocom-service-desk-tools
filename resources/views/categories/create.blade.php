<x-layouts.dashboard>
    <x-slot:title>
        Créer une catégorie
    </x-slot:title>

    <x-layouts.header
        title="Créer une catégorie"
        :breadcrumbs="[
            [
                'link' => route('projects.show', $project),
                'title' => $project->label,
            ],
            [
                'link' => route('projects.categories.index', $project),
                'title' => 'Catégories',
            ],
            [
                'title' => 'Créer',
            ],
        ]"/>

    <form
        method="POST"
        action="{{ route('projects.categories.store', $project) }}"
        class="form"
        x-data="categoryPreview(
            null,
            {{ Js::from($colors) }},
            {{ Js::from($categoryTypeColorSetting) }},
            {{ Js::from([
                'label' => old('label'),
                'font_color_id' => old('font_color_id'),
                'background_color_id' => old('background_color_id'),
                'border_top_color_id' => old('border_top_color_id'),
            ]) }}
        )"
        >

        @csrf

        <section class="form__section">

            <div class="form__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-info"></i>
                </div>

                <div>
                    <h2 class="form__title">Informations générales</h2>

                    <p class="form__description">
                        Définissez le nom de la catégorie
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                <x-forms.input
                    name="label"
                    label="Libellé"
                    required
                    x-model=label
                />

            </div>

        </section>

        <section class="form__section">

            <div class="form__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-regular fa-folder"></i>
                </div>

                <div>
                    <h2 class="form__title">Hiérarchie</h2>

                    <p class="form__description">
                        Choisissez la catégorie dans laquelle cette catégorie sera placée
                    </p>
                </div>
            </div>

            <div class="form__content category-form__hierarchy">

                <x-forms.category-selector
                    :categories="$categories"
                    name="parent_id"
                    type="category"
                />

            </div>

        </section>

        <section class="form__section form__section--split">

            <div class="form__main">

                <div class="form__header">
                    <div class="icon icon--round icon-title">
                        <i class="fa-solid fa-palette"></i>
                    </div>

                    <div>
                        <h2 class="form__title">Apparence</h2>

                        <p class="form__description">
                            Définissez les couleurs de la catégorie
                        </p>
                    </div>
                </div>

                <div class="form__content form__content--3">

                    <x-forms.color-selector 
                        name="font_color_id"
                        label="Texte"
                        :colors="$colors"
                        x-model="fontColorId"
                    />

                    <x-forms.color-selector 
                        name="background_color_id"
                        label="Arrière plan"
                        :colors="$colors"
                        x-model="backgroundColorId"
                    />

                    <x-forms.color-selector 
                        name="border_top_color_id"
                        label="Bordure supérieure"
                        :colors="$colors"
                        x-model="borderTopColorId"
                    />

                </div>

            </div>

            <aside class="form__aside">

                <div class="form__header">
                    <h2 class="form__title">Aperçu</h2>
                </div>

                <div class="form__content form__content--center">
                    <p 
                        x-text="label"
                        class="form__preview form__preview--category"
                        :style="{
                            color: fontColor,
                            background: bgColor,
                            borderTop: borderTopColor
                            }"
                        ></p>
                </div>

            </aside>

        </section>

        <div class="form__actions">
            <a
                class="header__link button button--cancel"
                href="{{ route('projects.show', $project) }}"
            >
                <i class="fa-solid fa-xmark"></i>
                <span>Annuler</span>
            </a>
        
            <button
                type="submit"
                class="header__link button button--primary"
            >
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Enregistrer</span>
            </button>
        </div>

    </form>

</x-layouts.dashboard>
