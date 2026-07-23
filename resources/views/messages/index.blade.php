<x-layouts.dashboard>
    <x-slot:title>
        Messages
    </x-slot:title>

    <div class="messages-index">
        <header class="messages-index__header">
            <div>
                <nav class="breadcrumb" aria-label="Fil d'Ariane">
                    <a href="{{ route('projects.show', ['project' => $project]) }}">
                        {{ $project->label }}
                    </a>

                    <span>/</span>

                    <span aria-current="page">
                        Messages
                    </span>
                </nav>

                <h1 class="messages-index__title">
                    Messages
                </h1>

                <p class="messages-index__subtitle">
                    Gérez les messages du projet {{ $project->label }}.
                </p>
            </div>

            <a
                href="{{ route('messages.create', ['project' => $project]) }}"
                class="messages-index__create-button"
            >
                <span aria-hidden="true">+</span>
                Créer un message
            </a>
        </header>

        <section class="messages-tree">
            @forelse ($categories as $category)
                @include('messages.partials.category-tree', [
                    'category' => $category,
                    'project' => $project,
                    'level' => 0,
                ])
            @empty
                <div class="messages-tree__empty">
                    <p>Aucune catégorie disponible pour ce projet.</p>
                </div>
            @endforelse
        </section>
    </div>
</x-layouts.dashboard>
