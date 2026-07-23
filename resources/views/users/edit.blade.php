<x-layouts.dashboard>
    <x-slot:title>
        Modifier un utilisateur
    </x-slot:title>

    <main class="user-create">
        <section class="user-create__card">
            <header class="user-create__header">
                <h1 class="user-create__title">
                    Modifier un utilisateur
                </h1>
            </header>

            <form class="user-form" method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="user-form__group">
                    <label class="user-form__label" for="firstname">
                        Prénom
                    </label>

                    <input
                        id="firstname"
                        class="user-form__input @error('firstname') user-form__input--error @enderror"
                        type="text"
                        name="firstname"
                        value="{{ old('firstname', $user->firstname) }}"
                        required
                    >

                    @error('firstname')
                        <p class="user-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="user-form__group">
                    <label class="user-form__label" for="lastname">
                        Nom
                    </label>

                    <input
                        id="lastname"
                        class="user-form__input @error('lastname') user-form__input--error @enderror"
                        type="text"
                        name="lastname"
                        value="{{ old('lastname', $user->lastname) }}"
                        required
                    >

                    @error('lastname')
                        <p class="user-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="user-form__group">
                    <label class="user-form__label" for="email">
                        Adresse e-mail
                    </label>

                    <input
                        id="email"
                        class="user-form__input @error('email') user-form__input--error @enderror"
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                    >

                    @error('email')
                        <p class="user-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="user-form__group">
                    <label class="user-form__label" for="password">
                        Nouveau mot de passe
                    </label>

                    <input
                        id="password"
                        class="user-form__input @error('password') user-form__input--error @enderror"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                    >

                    @error('password')
                        <p class="user-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="user-form__group">
                    <label class="user-form__label" for="password_confirmation">
                        Confirmation
                    </label>

                    <input
                        id="password_confirmation"
                        class="user-form__input"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                    >
                </div>

                <fieldset class="user-form__fieldset">
                    <legend class="user-form__legend">
                        Accès au projet
                    </legend>

                    <div class="user-form__group">
                        <label class="user-form__label" for="project_id">
                            Projet
                        </label>

                        <select
                            id="project_id"
                            class="user-form__select @error('memberships.0.project_id') user-form__select--error @enderror"
                            name="memberships[0][project_id]"
                            required
                        >
                            <option value="">Sélectionnez un projet</option>

                            @foreach ($projects as $project)
                                <option
                                    value="{{ $project->id }}"
                                    @selected(old('memberships.0.project_id', optional($user->memberships->first())->project_id) == $project->id)
                                >
                                    {{ $project->label }}
                                </option>
                            @endforeach
                        </select>

                        @error('memberships.0.project_id')
                            <p class="user-form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="user-form__group">
                        <label class="user-form__label" for="role_id">
                            Rôle
                        </label>

                        <select
                            id="role_id"
                            class="user-form__select @error('memberships.0.role_id') user-form__select--error @enderror"
                            name="memberships[0][role_id]"
                            required
                        >
                            <option value="">Sélectionnez un rôle</option>

                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->id }}"
                                    @selected(old('memberships.0.role_id', optional($user->memberships->first())->role_id) == $role->id)
                                >
                                    {{ $role->label }}
                                </option>
                            @endforeach
                        </select>

                        @error('memberships.0.role_id')
                            <p class="user-form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </fieldset>

                <fieldset class="user-form__fieldset">
                    <legend class="user-form__legend">
                        Permissions globales
                    </legend>

                    <label class="user-form__switch">
                        <div>
                            <span class="user-form__switch-title">
                                Administrateur
                            </span>

                            <span class="user-form__switch-description">
                                Accès complet à l'application.
                            </span>
                        </div>

                        <input
                            type="checkbox"
                            name="is_admin"
                            value="1"
                            @checked(old('is_admin', $user->is_admin))
                        >
                    </label>

                    <label class="user-form__switch">
                        <div>
                            <span class="user-form__switch-title">
                                Knowledge Manager
                            </span>

                            <span class="user-form__switch-description">
                                Gestionnaire de la base de connaissances.
                            </span>
                        </div>

                        <input
                            type="checkbox"
                            name="is_knowledge_manager"
                            value="1"
                            @checked(old('is_knowledge_manager', $user->is_knowledge_manager))
                        >
                    </label>
                </fieldset>

                <div class="user-form__actions">
                    <button class="user-form__submit" type="submit">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </section>
    </main>
</x-layouts.dashboard>
