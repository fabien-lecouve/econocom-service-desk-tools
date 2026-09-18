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
                'link' => route('categories.index', $project),
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
        action="{{ route('categories.store', $project) }}"
        class="form"
        >

        @csrf

        <input
            type="hidden"
            name="project_id"
            value="{{ $project->id }}"
        >

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

                <x-forms.number
                    name="position"
                    label="Position"
                    :value="1"
                    min="1"
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

                    <x-forms.select
                        name="font_color_id"
                        label="Texte"
                        :options="$colors"
                        placeholder="Choisiez une couleur"
                    />

                    <x-forms.select
                        name="background_color_id"
                        label="Arrière plan"
                        :options="$colors"
                        placeholder="Choisiez une couleur"
                    />

                    <x-forms.select
                        name="border_top_color_id"
                        label="Bordure supérieure"
                        :options="$colors"
                        placeholder="Choisiez une couleur"
                    />

                </div>

            </div>

            <aside class="form__aside">

                <div class="form__header">
                    <h2 class="form__title">Aperçu</h2>
                </div>

                <div class="form__content">
                    <p>Catégorie</p>
                </div>

            </aside>

        </section>
    </form>

</x-layouts.dashboard>
