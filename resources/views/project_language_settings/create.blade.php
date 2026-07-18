<x-layouts.dashboard>
    <x-slot:title>
        Créer la signature du projet {{ $project->label }}
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">Créer la signature du projet {{ $project->label }}</h1>
    </header>

    <div class="main__content">
        <form class="form" method="POST" action="{{ route('project-language-settings.store') }}" enctype="multipart/form-data">
            @csrf

            <x-forms.input
                name="project_id"
                :value="$project->id"
                type="hidden"
            />

            @foreach ($languages as $language)

                <x-forms.input
                    name="languages[{{ $language->id }}][language_id]"
                    :value="$language->id"
                    type="hidden"
                />

                <x-forms.textarea
                    name="languages[{{ $language->id }}][signature]"
                    label="Signature {{ $language->code }}"
                    rows="8"
                    required
                />

                <x-forms.input
                    name="languages[{{ $language->id }}][internal_phone_override]"
                    label="Numéro de téléphone {{ $language->code }} interne (remplace le numéro par défaut)"
                />

                <x-forms.input
                    name="languages[{{ $language->id }}][external_phone_override]"
                    label="Numéro de téléphone {{ $language->code }} externe (remplace le numéro par défaut)"
                />

            @endforeach

            <x-forms.submit label="Créer" />

        </form>
    </div>

</x-layouts.dashboard>
