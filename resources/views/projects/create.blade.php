<x-layouts.dashboard>
    <x-slot:title>
        Créer un projet
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">Créer un projet</h1>
    </header>

    <div class="main__content">
        <form class="form" method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf

            <x-forms.input name="label" label="Libellé" required />

            <x-forms.input name="phone" label="Téléphone" />

            <x-forms.input name="email" label="Email" />

            <x-forms.checkbox
                name="languages"
                legend="Choisissez les langues du projet"
                :options="$languages"
                required
            />

            <x-forms.submit label="Créer" />

        </form>
    </div>

</x-layouts.dashboard>
