<x-layouts.dashboard>
    <x-slot:title>
        Catégories
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">Catégories</h1>
        {{-- <x-buttons.link type="add" :href="route('categories.create')">
            Créer une catégorie
        </x-buttons.link> --}}
    </header>

    <div class="main__content">
        <table class="table">
            <thead class="table__head">
                <tr class="table__row">
                    <th class="table__cell">Code</th>
                    <th class="table__cell">Label</th>
                    <th class="table__cell"></th>
                </tr>
            </thead>

            <tbody class="table__body">

                @foreach ($categories as $category)
                    <tr class="table__row">
                        <td class="table__cell">{{ $category->code }}</td>
                        <td class="table__cell">{{ $category->label }}</td>
                        <td class="table__cell table__actions">
                            <a href="{{ route('categories.show', $category) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('categories.edit', $category) }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openModal('confirmDelete', () => this.form.submit())">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <x-modals.confirm id="confirmDelete" title="Supprimer cette catégorie ?" />

</x-layouts.dashboard>
