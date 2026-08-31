<x-layouts.dashboard>
    <x-slot:title>
        Projets
    </x-slot:title>

    <x-layouts.header
        title="Projets"
        :breadcrumbs="[
            [
                'title' => 'Projets',
            ],
        ]" :actions="[
            [
                'type' => 'link',
                'link' => route('projects.create'),
                'label' => 'Créer un projet',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-plus',
            ],
        ]"
    />

    <div class="table-container">

        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th>Code</th>
                    <th>Libellé</th>
                    <th>Téléphone interne</th>
                    <th>Téléphone externe</th>
                    <th>Langues</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody class="table__tbody">

                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->code }}</td>
                        <td>{{ $project->label }}</td>
                        <td>{{ $project->internal_phone }}</td>
                        <td>{{ $project->external_phone }}</td>
                        <td>
                            @foreach ($project->projectLanguageSettings as $setting)
                                {{ $setting->language->label }}
                            @endforeach
                        </td>

                        <td class="actions">
                            <a class="actions__show" href="{{ route('projects.show', ['project' => $project]) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="actions__edit" href="{{ route('projects.edit', $project) }}" class="btn btn--secondary">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf
                                @method('DELETE')

                                <button class="actions__delete"  type="submit" class="btn btn--danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</x-layouts.dashboard>
