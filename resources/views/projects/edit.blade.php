<x-layouts.dashboard>
    <x-slot:title>
        Modifier une catégorie
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">Modifier une catégorie</h1>
        <x-buttons.link type="back" :href="route('categories.index')">
            Retour aux catégories
        </x-buttons.link>
    </header>

    <div class="main__content">
        <form class="form" method="POST" action="{{ route('categories.update', ['category => $category']) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-forms.input name="code" label="Code" :value="$category->code" required />

            <x-forms.input name="label" label="Libellé" :value="$category->label" required />

            <x-forms.submit label="Enregistrer" />

        </form>
    </div>

</x-layouts.dashboard>
