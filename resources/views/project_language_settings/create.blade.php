<x-layouts.dashboard>
    <x-slot:title>
        Projet {{ ucfirst($project->label) }}
    </x-slot:title>

    <x-layouts.header
        title="Projet {{ ucfirst($project->label) }}"
        :breadcrumbs="[
            [
                'link' => route('projects.show', $project),
                'title' => ucfirst($project->label),
            ],
            [
                'title' => 'Paramétrer',
            ],
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('projects.show', $project),
                'label' => 'Annuler',
                'icon' => 'fa-solid fa-xmark',
                'policy' => 'create',
                'model' => App\Models\Project::class,
            ],
            [
                'type' => 'submit',
                'label' => 'Enregistrer',
                'form' => 'project-settings-create-form',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-floppy-disk',
                'policy' => 'create',
                'model' => App\Models\Project::class,
            ]
        ]" />

    <form
        id="project-settings-create-form"
        method="POST"
        action="{{ route('projects.language-settings.store', $project) }}"
        class="form"
        >

        @csrf

        <x-forms.hidden
            name="project_id"
            :value="$project->id"
        />

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

                @foreach ($project->projectLanguageSettings as $languageSetting)

                    <div class="form__columns">

                        <x-forms.hidden
                            name="languages[{{ $languageSetting->language_id }}][language_id]"
                            :value="$languageSetting->language_id"
                        />

                        <x-forms.textarea
                            name="languages[{{ $languageSetting->language_id }}][signature]"
                            label="Signature {{ strtoupper($languageSetting->language->code) }}"
                            rows="10"
                            required
                        />

                        <x-forms.input
                            name="languages[{{ $languageSetting->language_id }}][internal_phone_override]"
                            label="Numéro de téléphone {{ strtoupper($languageSetting->language->code) }} interne (remplace le numéro par défaut)"
                            placeholder="1000"
                        />

                        <x-forms.input
                            name="languages[{{ $languageSetting->language_id }}][external_phone_override]"
                            label="Numéro de téléphone {{ strtoupper($languageSetting->language->code) }} externe (remplace le numéro par défaut)"
                            placeholder="01 02 03 04 05"
                        />

                    </div>

                @endforeach

            </div>

        </section>

        <x-forms.notice />

    </form>

</x-layouts.dashboard>


