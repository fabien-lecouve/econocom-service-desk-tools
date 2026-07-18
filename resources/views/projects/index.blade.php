<x-layouts.dashboard>
    <x-slot:title>
        Projets
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">Projets</h1>
    </header>

    <div class="main__content">
        <table class="table">
            <thead class="table__head">
                <tr class="table__row">
                    <th class="table__cell">Code</th>
                    <th class="table__cell">Libellé</th>
                    <th class="table__cell">Téléphone interne</th>
                    <th class="table__cell">Téléphone externe</th>
                    <th class="table__cell">Langues</th>
                </tr>
            </thead>

            <tbody class="table__body">

                @foreach ($projects as $project)
                    <tr class="table__row">
                        <td class="table__cell">{{ $project->code }}</td>
                        <td class="table__cell">{{ $project->label }}</td>
                        <td class="table__cell">{{ $project->internal_phone }}</td>
                        <td class="table__cell">{{ $project->external_phone }}</td>
                        <td class="table__cell">
                            @foreach ($project->projectLanguageSettings as $setting)
                                {{ $setting->language->label }}
                            @endforeach
                        </td>
                        <td class="table__cell table__actions">
                            <a href="{{ route('projects.show', ['project' => $project]) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</x-layouts.dashboard>
