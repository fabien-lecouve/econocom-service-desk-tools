<x-layouts.dashboard>
    <x-slot:title>
        Catégories
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">
            {{ $project->label }} - Catégories
        </h1>

        <a href="{{ route('categories.create', $project) }}" class="button">
            Créer une catégorie
        </a>
    </header>

    <div class="main__content">
        <div class="category-tree">

            @foreach ($categories as $category)
                @include('categories.partials.category', ['category' => $category, 'level' => 0])
            @endforeach

        </div>
    </div>

</x-layouts.dashboard>
