<x-layouts.dashboard>
    <x-slot:title>
        Créer un message
    </x-slot:title>

    <x-layouts.header
        title="Créer un message"
        :breadcrumbs="[
            [
                'link' => route('projects.show', $project),
                'title' => $project->label,
            ],
            [
                'link' => route('projects.messages.index', $project),
                'title' => 'Messages',
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
                'model' => [App\Models\Message::class, $project],
            ],
            [
                'type' => 'submit',
                'label' => 'Enregistrer',
                'form' => 'message-create-form',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-floppy-disk',
                'policy' => 'create',
                'model' => [App\Models\Message::class, $project],
            ]
        ]"
    />

    <form
        id="message-create-form"
        method="POST"
        action="{{ route('projects.messages.store', $project) }}"
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

            <div class="form__content form__content--3">

                <x-forms.input
                    name="label"
                    label="Libellé"
                    required
                />

                <x-forms.select
                    name="message_type_id"
                    label="Type de message"
                    :options="$types"
                    placeholder="Sélectionner un type de message"
                    required
                />

                <x-forms.input
                    name="shortcut"
                    label="Raccourci clavier"
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

            <table class="table">
                <colgroup>
                    <col class="table__col--20">
                    <col class="table__col--80">
                </colgroup>
                <thead class="table__thead">
                    <tr>
                        <th>Langue</th>
                        <th>Contenu du message</th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    @foreach ($project->projectLanguageSettings as $setting)

                        @php
                            $languageId = $setting->language->id;
                        @endphp
                        <tr>
                            <td><span class="badge">{{ strtoupper($setting->language->code) }}</span> {{ $setting->language->label}}</td>
                            <td class="no-padding">
                                <x-forms.hidden
                                    name="translations[{{ $languageId }}][language_id]"
                                    value="{{ $languageId }}"
                                />

                                <x-forms.textarea
                                    name="translations[{{ $languageId }}][content]"
                                    rows="15"
                                    class="table__textarea"
                                    required
                                />
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>

        </section>
    </form>

</x-layouts.dashboard>

