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
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('projects.show', $project),
                'label' => 'Annuler',
                'icon' => 'fa-solid fa-xmark',
                'policy' => 'create',
                'model' => [App\Models\Category::class, $project],
            ],
            [
                'type' => 'submit',
                'label' => 'Enregistrer',
                'form' => 'category-create-form',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-floppy-disk',
                'policy' => 'create',
                'model' => [App\Models\Category::class, $project],
            ]
        ]" />

    <form
        id="category-create-form"
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
    </form>

</x-layouts.dashboard>
