<x-layouts.dashboard>
    <x-slot:title>
        Modifier {{ $user->firstname . ' ' . $user->lastname }}
    </x-slot:title>

    <x-layouts.header
        :title="'Modifier ' . $user->firstname . ' ' . $user->lastname"
        :breadcrumbs="[
            [
                'link' => route('users.index'),
                'title' => 'Utilisateurs',
            ],
            [
                'title' => 'Créer',
            ],
        ]"/>

    <form
        method="POST"
        action="{{ route('users.update', $user) }}"
        class="form"
        >

        @csrf
        @method('PUT')

        <section class="form__section">

            <div class="form__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-info"></i>
                </div>

                <div>
                    <h2 class="form__title">Informations générales</h2>

                    <p class="form__description">
                        Renseignez les informations de l'utilisateur
                    </p>
                </div>
            </div>

            <div class="form__content form__content--3">

                <x-forms.input
                    name="lastname"
                    label="Nom"
                    :value="old('lastname', $user->lastname)"
                    required
                />

                <x-forms.input
                    name="firstname"
                    label="Prénom"
                    :value="old('firstname', $user->firstname)"
                    required
                />

                <x-forms.input
                    name="email"
                    label="Adresse e-mail"
                    type="email"
                    :value="old('email', $user->email)"
                    required
                />

            </div>

        </section>

        <section class="form__section">

            <div class="form__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-key"></i>
                </div>

                <div>
                    <h2 class="form__title">Sécurité</h2>

                    <p class="form__description">
                        Définissez le mot de passe de l'utilisateur
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                <x-forms.input
                    name="password"
                    label="Mot de passe"
                    type="password"
                    required
                />

                <x-forms.input
                    name="password_confirmation"
                    label="Confirmer le mot de passe"
                    type="password"
                    required
                />

            </div>

        </section>

        <section class="form__section">

            <div class="form__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-chart-diagram"></i>
                </div>

                <div>
                    <h2 class="form__title">Projet</h2>

                    <p class="form__description">
                        Affectez l'utilisateur à un projet et définissez son rôle
                    </p>
                </div>
            </div>

            <div
                x-data="{
                    memberships: @js(
                        old('memberships', $user->memberships->map(fn ($membership) => [
                            'project_id' => $membership->project_id,
                            'role_id' => $membership->role_id,
                        ])->values()->all())
                    )
                }"
            >
                <template x-for="(membership, index) in memberships" :key="index">
                    <div class="form__content form__content--3">

                        <x-forms.select
                            x-bind:name="`memberships[${index}][project_id]`"
                            x-model="membership.project_id"
                            label="Projet"
                            :options="$projects"
                            placeholder="Sélectionnez un projet"
                            required
                        />

                        <x-forms.select
                            x-bind:name="`memberships[${index}][role_id]`"
                            x-model="membership.role_id"
                            label="Rôle"
                            :options="$roles"
                            placeholder="Sélectionnez un rôle"
                            required
                        />

                        <button
                            type="button"
                            x-show="memberships.length > 1"
                            @click="memberships.splice(index, 1)"
                        >
                            Supprimer
                        </button>

                    </div>
                </template>

                <button
                    type="button"
                    @click="memberships.push({
                        project_id: '',
                        role_id: ''
                    })"
                >
                    + Ajouter un projet
                </button>
            </div>

        </section>

        <section class="form__section">

            <div class="form__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-shield"></i>
                </div>

                <div>
                    <h2 class="form__title">Permissions globales</h2>

                    <p class="form__description">
                        Définissez les permissions globales de l'utilisateur
                    </p>
                </div>
            </div>

            <div class="form__content form__content--2">

                <x-forms.boolean-checkbox
                    name="is_admin"
                    label="Administrateur"
                    :value="$user->is_admin"
                />

                <x-forms.boolean-checkbox
                    name="is_knowledge_manager"
                    label="Knowledge Manager"
                    :value="$user->is_knowledge_manager"
                />

            </div>

        </section>

        <div class="form__actions">
            <a
                class="header__link button button--cancel"
                href="{{ route('users.index') }}"
            >
                <i class="fa-solid fa-xmark"></i>
                <span>Annuler</span>
            </a>
        
            <button
                type="submit"
                class="header__link button button--primary"
            >
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Enregistrer</span>
            </button>
        </div>

    </form>

</x-layouts.dashboard>
