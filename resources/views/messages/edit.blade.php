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
                'link' => route('projects.messages.index', $project),
                'title' => 'Messages',
            ],
            [
                'title' => $message->label,
            ],
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('projects.messages.index', $project),
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
        action="{{ route('projects.messages.update', [$project, $message]) }}"
        class="form"
        x-data="messagePreview(
            {{ Js::from($message) }},
            {{ Js::from($colors) }},
            {{ Js::from($messageTypeColorSettings) }},
            {{ Js::from([
                'label' => old('label', $message->label),
                'message_type_id' => old('message_type_id', $message->message_type_id),
                'font_color_id' => old('font_color_id', $message->font_color_id),
                'background_color_id' => old('background_color_id', $message->background_color_id),
                'border_top_color_id' => old('border_top_color_id', $message->border_top_color_id),
            ]) }}
        )"
    >

        @csrf
        @method('PUT')

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
                    x-model=label
                />

                <x-forms.select
                    name="message_type_id"
                    label="Type de message"
                    :options="$types"
                    :value="old('message_type_id', $message->message_type_id)"
                    placeholder="Sélectionner un type de message"
                    required
                    x-model=messageTypeId
                />

                {{-- <x-forms.input
                    name="shortcut"
                    label="Raccourci clavier"
                    :value="old('shortcut', $message->shortcut)"
                /> --}}

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

                    <x-forms.color-selector 
                        name="font_color_id"
                        label="Texte"
                        :colors="$colors"
                        :value="$message->font_color_id"
                        x-model="fontColorId"
                    />

                    <x-forms.color-selector 
                        name="background_color_id"
                        label="Arrière plan"
                        :colors="$colors"
                        :value="$message->background_color_id"
                        x-model="backgroundColorId"
                    />

                    <x-forms.color-selector 
                        name="border_top_color_id"
                        label="Bordure supérieure"
                        :colors="$colors"
                        :value="$message->border_top_color_id"
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
                        class="form__preview form__preview--message"
                        :style="{
                            color: fontColor,
                            background: bgColor,
                            borderTop: borderTopColor
                            }"
                        ></p>
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
                    <col class="table__col--15">
                    <col class="table__col--85">
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

                            $translation = $message
                                ->translations
                                ->firstWhere('language_id', $languageId);
                            $value = old(
                                "translations.$languageId.content",
                                $translation?->content
                            );
                        @endphp
                        <tr>
                            <td class="center"><span class="badge">{{ strtoupper($setting->language->code) }}</span></td>
                            <td class="no-padding">
                                <x-forms.hidden
                                    name="translations[{{ $languageId }}][language_id]"
                                    value="{{ $languageId }}"
                                />

                                <x-forms.textarea
                                    name="translations[{{ $languageId }}][content]"
                                    :value="$value"
                                    rows="15"
                                    required
                                />
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>

        </section>

        <x-forms.notice />

    </form>

</x-layouts.dashboard>
