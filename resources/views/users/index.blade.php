<x-layouts.dashboard>
    <x-slot:title>
        Utilisateurs
    </x-slot:title>

    <x-layouts.header
        title="Utilisateurs"
        :breadcrumbs="[
            [
                'title' => 'Utilisateurs',
            ],
        ]" :actions="[
            [
                'type' => 'link',
                'link' => route('users.create'),
                'label' => 'Créer un utilisateur',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-plus',
                'policy' => 'create',
                'model' => [App\Models\User::class],
            ],
        ]"
    />

    <div class="table-container">

        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Projets</th>
                    <th>Admin</th>
                    <th>KM</th>
                    <th>Activité</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->firstname }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            @forelse($user->memberships as $membership)
                                <div>
                                    <strong>{{ $membership->project->label }}</strong>
                                    <span class="role role--{{ $membership->role->code }}">
                                        ({{ $membership->role->label }})
                                    </span>
                                </div>
                            @empty
                                <em>Aucun</em>
                            @endforelse
                        </td>

                        <td class="center">
                            {{ $user->is_admin ? '✔' : '✖' }}
                        </td>

                        <td class="center">
                            {{ $user->is_knowledge_manager ? '✔' : '✖' }}
                        </td>

                        <td class="table__activity">
                            @if ($user->last_activity_at?->greaterThan(now()->subHours(48)))
                                <div class="active" title="Actif ces dernières 48 heures" aria-label="Actif ces dernières 48 heures"></div>
                            @elseif ($user->last_activity_at?->greaterThan(now()->subWeek()))
                                <div class="less-active" title="Actif ces 7 derniers jours" aria-label="Actif ces 7 derniers jours"></div>
                            @else
                                <div class="inactive" title="Inactif depluis d'une semaine" aria-label="Inactif depluis d'une semaine"></div>
                            @endif
                        </td>

                        <td class="actions">
                            <a class="actions__edit btn btn--secondary" href="{{ route('users.edit', $user) }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf
                                @method('DELETE')

                                <button class="actions__delete btn btn--danger"  type="submit">
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
