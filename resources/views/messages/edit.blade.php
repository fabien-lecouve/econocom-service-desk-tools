<x-layouts.dashboard>
    <x-slot:title>
        Modifier {{ $message->label }}
    </x-slot:title>

    <x-layouts.header
        :title="'Modifier ' . $message->label"
        :breadcrumbs="[
            [
                'link' => route('projects.show', $project),
                'title' => $project->label,
            ],
            [
                'link' => route('messages.index', $project),
                'title' => 'Messages',
            ],
            [
                'title' => $message->label,
            ],
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('messages.index', $project),
                'label' => 'Annuler',
                'icon' => 'fa-solid fa-xmark',
                'policy' => 'update',
                'model' => [$message, $project],
            ],
            [
                'type' => 'submit',
                'label' => 'Enregistrer',
                'form' => 'message-edit-form',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-floppy-disk',
                'policy' => 'update',
                'model' => [$message, $project],
            ]
        ]"
    />

    <form
        id="message-edit-form"
        method="POST"
        action="{{ route('messages.update', [$project, $message]) }}"
        class="form"
    >

        @csrf
        @method('PUT')

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

            <div class="form__content form__content--3">

                <x-forms.input
                    name="label"
                    label="Libellé"
                    :value="old('label', $message->label)"
                    required
                />

                <x-forms.select
                    name="message_type_id"
                    label="Type de message"
                    :options="$types"
                    :value="old('message_type_id', $message->message_type_id)"
                    placeholder="Sélectionner un type de message"
                    required
                />

                <x-forms.input
                    name="shortcut"
                    label="Raccourci clavier"
                    :value="old('shortcut', $message->shortcut)"
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
                    name="category_id"
                    type="message"
                    :initialCategoryId="$message->category_id"
                />

                <x-forms.number
                    name="position"
                    label="Position"
                    :value="old('position', $message->position)"
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
                        placeholder="Couleur"
                    />

                    <x-forms.select
                        name="background_color_id"
                        label="Fond"
                        placeholder="Couleur"
                    />

                    <x-forms.select
                        name="border_top_color_id"
                        label="Bordure"
                        placeholder="Couleur"
                    />

                </div>

            </div>

            <aside class="form__aside">

                <div class="form__header">
                    <h2 class="form__title">Aperçu</h2>
                </div>

                <div class="form__content">
                    <p>Message</p>
                </div>

            </aside>

        </section>

        <section class="form__section">

            <div class="form__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-globe"></i>
                </div>

                <div>
                    <h2 class="form__title">Traductions</h2>

                    <p class="form__description">
                        Ajoutez le contenu du message pour chaque langue activée sur ce projet
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                @foreach ($project->projectLanguageSettings as $setting)

                    @php
                        $languageId = $setting->language->id;

                        $translation = $message
                            ->translations
                            ->firstWhere('language_id', $languageId);
                        $value = old(
                            "translations.$languageId.content",
                            $translation?->content
                        );
                    @endphp

                    <x-forms.hidden
                        name="translations[{{ $languageId }}][language_id]"
                        value="{{ $languageId }}"
                    />

                    <x-forms.textarea
                        name="translations[{{ $languageId }}][content]"
                        label="Corps du message {{ $setting->language->code }}"
                        :value="$value"
                        rows="15"
                        required
                    />

                @endforeach

            </div>

        </section>
    </form>

</x-layouts.dashboard>
