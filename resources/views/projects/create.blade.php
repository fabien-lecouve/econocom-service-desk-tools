<x-layouts.dashboard>
    <x-slot:title>
        Créer un projet
    </x-slot:title>

    <x-layouts.header
        title="Créer un projet"
        :breadcrumbs="[
            [
                'title' => 'Créer',
            ],
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('projects.index'),
                'label' => 'Annuler',
                'icon' => 'fa-solid fa-xmark',
                'policy' => 'create',
                'model' => App\Models\Project::class,
            ],
            [
                'type' => 'submit',
                'label' => 'Enregistrer',
                'form' => 'project-create-form',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-floppy-disk',
                'policy' => 'create',
                'model' => App\Models\Project::class,
            ]
        ]" />

    <form
        id="project-create-form"
        method="POST"
        action="{{ route('projects.store') }}"
        class="form"
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
                        Définissez les paramètres du projet
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                <x-forms.input
                    name="label"
                    label="Libellé"
                    placeholder="Econocom"
                    required
                />

                <x-forms.input
                    name="internal_phone"
                    label="Numéro de téléphone interne"
                    placeholder="1000"
                />

                <x-forms.input
                    name="email"
                    label="Email"
                    placeholder="support@econocom.com"
                />

                <x-forms.input
                    name="external_phone"
                    label="Numéro de téléphone externe"
                    placeholder="01 02 03 04 05"
                />

            </div>

        </section>

        <section class="form__section">

            <div class="form__header">

                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-globe"></i>
                </div>

                <div>
                    <h2 class="form__title">Langues</h2>

                    <p class="form__description">
                        Choisissez les langues du projet
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                <x-forms.checkbox
                    name="languages"
                    :options="$languages"
                />

            </div>

        </section>

        <x-forms.notice />

    </form>

</x-layouts.dashboard>
