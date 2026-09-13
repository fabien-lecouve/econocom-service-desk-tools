<x-layouts.dashboard>
    <x-slot:title>
        Catégories
    </x-slot:title>

    <x-layouts.header
        title="Catégories"
        :breadcrumbs="[
            [
                'link' => route('projects.show', $project),
                'title' => $project->label,
            ],
            [
                'title' => 'Catégories',
            ]
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('categories.create', $project),
                'label' => 'Créer une catégorie',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-plus',
                'policy' => 'create',
                'model' => [App\Models\Category::class, $project],
            ]
        ]" />


    <div class="tree">

        @foreach ($categories as $category)
            @include('categories.partials.category', ['category' => $category, 'level' => 0])
        @endforeach

    </div>

</x-layouts.dashboard>
