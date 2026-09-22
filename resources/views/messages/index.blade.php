<x-layouts.dashboard>
    <x-slot:title>
        Messages
    </x-slot:title>

    <x-layouts.header
        title="Messages"
        :breadcrumbs="[
            [
                'link' => route('projects.show', $project),
                'title' => $project->label,
            ],
            [
                'title' => 'Messages',
            ]
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('projects.messages.create', $project),
                'label' => 'Créer un message',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-plus',
                'policy' => 'create',
                'model' => [App\Models\Message::class, $project],
            ]
        ]" />

    <div class="tree">
        @foreach ($categories as $category)
            @include('messages.partials.category-tree', [
                'category' => $category,
                'project' => $project,
                'level' => 0,
            ])
        @endforeach
    </div>

</x-layouts.dashboard>
