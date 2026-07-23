<x-layouts.dashboard>
    <x-slot:title>
        Utilisateurs
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">Utilisateurs</h1>
    </header>

    <div class="main__content">
        <table class="table">
            <thead class="table__head">
                <tr class="table__row">
                    <th class="table__cell">Prénom</th>
                    <th class="table__cell">Nom</th>
                    <th class="table__cell">Email</th>
                    <th class="table__cell">Projets</th>
                    <th class="table__cell">Admin</th>
                    <th class="table__cell">Knowledge Manager</th>
                    <th class="table__cell table__cell--actions">Actions</th>
                </tr>
            </thead>

            <tbody class="table__body">
                @foreach ($users as $user)
                    <tr class="table__row">
                        <td class="table__cell">{{ $user->firstname }}</td>
                        <td class="table__cell">{{ $user->lastname }}</td>
                        <td class="table__cell">{{ $user->email }}</td>

                        <td class="table__cell">
                            @forelse($user->memberships as $membership)
                                <div>
                                    <strong>{{ $membership->project->label }}</strong>
                                    <small>({{ $membership->role->label }})</small>
                                </div>
                            @empty
                                <em>Aucun</em>
                            @endforelse
                        </td>

                        <td class="table__cell">
                            {{ $user->is_admin ? '✔' : '✖' }}
                        </td>

                        <td class="table__cell">
                            {{ $user->is_knowledge_manager ? '✔' : '✖' }}
                        </td>

                        <td class="table__cell table__cell--actions">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn--secondary">
                                Modifier
                            </a>

                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn--danger">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.dashboard>
