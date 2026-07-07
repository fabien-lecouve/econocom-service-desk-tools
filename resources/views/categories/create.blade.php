<x-layouts.dashboard>
    <x-slot:title>
        Créer une catégorie
    </x-slot:title>

    <div class="main__content">
        <form class="form" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf

            <x-forms.select name="project_id" label="Projet" :options="$projects" required />

            <x-forms.select name="parent_id" label="Parent" placeholder="Aucun" required />

            <x-forms.input name="code" label="Code" required />

            <x-forms.input name="label" label="Libellé" required />

            <x-forms.submit label="Créer" />

        </form>
    </div>

</x-layouts.dashboard>
