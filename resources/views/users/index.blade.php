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
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Projets</th>
                    <th>Admin</th>
                    <th>Knowledge Manager</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->firstname }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            @forelse($user->memberships as $membership)
                                <div>
                                    <strong>{{ $membership->project->label }}</strong>
                                    <small>({{ $membership->role->label }})</small>
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

                        <td class="actions">
                            <a class="actions__edit" href="{{ route('users.edit', $user) }}" class="btn btn--secondary">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('users.destroy', $user) }}" method="POST"
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
