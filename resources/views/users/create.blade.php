<x-layouts.dashboard>
    <x-slot:title>
        Créer un utilisateur
    </x-slot:title>

    <x-layouts.header
        title="Créer un utilisateur"
        :breadcrumbs="[
            [
                'link' => route('users.index'),
                'title' => 'Utilisateurs',
            ],
            [
                'title' => 'Créer',
            ],
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('users.index'),
                'label' => 'Annuler',
                'icon' => 'fa-solid fa-xmark',
                'policy' => 'create',
                'model' => App\Models\User::class,
            ],
            [
                'type' => 'submit',
                'label' => 'Enregistrer',
                'form' => 'user-create-form',
                'class' => 'button--primary',
                'icon' => 'fa-solid fa-floppy-disk',
                'policy' => 'create',
                'model' => App\Models\User::class,
            ]
        ]" />

    <form
        id="user-create-form"
        method="POST"
        action="{{ route('users.store') }}"
        class="form"
        >

        @csrf

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
                    name="firstname"
                    label="Prénom"
                    required
                />

                <x-forms.input
                    name="lastname"
                    label="Nom"
                    required
                />

                <x-forms.input
                    name="email"
                    label="Adresse e-mail"
                    type="email"
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

            <div class="form__content form__content--2">

                <x-forms.select
                    name="memberships[0][project_id]"
                    label="Projet"
                    :options="$projects"
                    placeholder="Sélectionnez un projet"
                    required
                />

                <x-forms.select
                    name="memberships[0][role_id]"
                    label="Rôle"
                    :options="$roles"
                    placeholder="Sélectionnez un rôle"
                    required
                />

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
                />

                <x-forms.boolean-checkbox
                    name="is_knowledge_manager"
                    label="Knowledge Manager"
                />

            </div>

        </section>

    </form>

</x-layouts.dashboard>
