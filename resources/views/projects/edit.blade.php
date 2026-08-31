<x-layouts.dashboard>
    <x-slot:title>
        Modifier {{ ucfirst($project->label) }}
    </x-slot:title>

    <x-layouts.header
        title="Projet {{ ucfirst($project->label) }}"
        :breadcrumbs="[
            [
                'link' => route('projects.index'),
                'title' => 'Projets',
            ],
            [
                'link' => route('projects.show', $project),
                'title' => ucfirst($project->label),
            ],
            [
                'title' => 'Modifier',
            ],
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('projects.show', $project),
                'label' => 'Annuler',
                'icon' => 'fa-solid fa-xmark'
            ],
            [
                'type' => 'submit',
                'label' => 'Enregistrer',
                'form' => 'project-edit-form',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-floppy-disk'
            ]
        ]" />

    <form
        id="project-edit-form"
        method="POST"
        action="{{ route('projects.update',$project) }}"
        class="form"
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
                        Définissez les paramètres du projet
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                <x-forms.input
                    name="label"
                    label="Libellé"
                    placeholder="Econocom"
                    value="{{ old('label', $project->label) }}"
                    required
                />

                <x-forms.input
                    name="internal_phone"
                    label="Numéro de téléphone interne"
                    placeholder="1000"
                    value="{{ old('internal_phone', $project->internal_phone) }}"
                />

                <x-forms.input
                    name="email"
                    label="Email"
                    placeholder="support@econocom.com"
                    value="{{ old('email', $project->email) }}"
                />

                <x-forms.input
                    name="external_phone"
                    label="Numéro de téléphone externe"
                    placeholder="01 02 03 04 05"
                    value="{{ old('external_phone', $project->external_phone) }}"
                />

            </div>

        </section>

        <section class="form__section">

            <div class="form__header">

                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-globe"></i>
                </div>

                <div>
                    <h2 class="form__title">Paramètres par langue</h2>

                    <p class="form__description">
                        Personnalisez la signature et, si nécessaire, remplacez les numéros de téléphone par défaut pour chaque langue
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                @foreach ($languages as $index => $language)
                    @php
                        $setting = $project->projectLanguageSettings
                            ->firstWhere('language_id', $language->id);
                    @endphp

                    <div class="form__columns">

                        <x-forms.hidden
                            name="languages[{{ $index }}][language_id]"
                            :value="$language->id"
                        />

                        <x-forms.textarea
                            name="languages[{{ $index }}][signature]"
                            label="Signature {{ strtoupper($language->code) }}"
                            rows="10"
                            placeholder="Saisissez la signature utilisée pour cette langue"
                            :value="old('languages.' . $index . '.signature', $setting?->signature)"
                            required
                        />

                        <x-forms.input
                            name="languages[{{ $index }}][internal_phone_override]"
                            label="Numéro de téléphone {{ strtoupper($language->code) }} interne (remplace le numéro par défaut)"
                            placeholder="Laisser vide pour utiliser la valeur générale"
                            :value="old('languages.' . $index . '.internal_phone_override', $setting?->internal_phone_override)"
                        />

                        <x-forms.input
                            name="languages[{{ $index }}][external_phone_override]"
                            label="Numéro de téléphone {{ strtoupper($language->code) }} externe (remplace le numéro par défaut)"
                            placeholder="Laisser vide pour utiliser la valeur générale"
                            :value="old('languages.' . $index . '.external_phone_override', $setting?->external_phone_override)"
                        />

                    </div>

                @endforeach

            </div>

        </section>

        <x-forms.notice />

    </form>
</x-layouts.dashboard>
