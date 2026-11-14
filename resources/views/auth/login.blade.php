<x-layouts.guest>
    <x-slot:title>
        Se connecter
    </x-slot:title>

    <form
        method="POST"
        action="/login"
        class="guest__form"
        >

        @csrf

        <section class="guest__section">
            <h1 class="guest__title">Econocom</h1>
            <div class="guest__header">
                <h2 class="guest__subtitle">Service Desk Tools</h2>

                <small class="guest__description">
                    Votre outil interne de support et de gestion des activités Service Desk
                </small>
            </div>

            <div class="guest__content">
                <ul class="guest__list">
                    <li class="guest__item">
                        <div class="icon icon--square icon-title">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <h3>Messages rapides</h3>
                            <small>Modèles standardisés et prêts à l'emploi</small>
                        </div>
                    </li>
                    <li class="guest__item">
                        <div class="icon icon--square icon-title">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div>
                            <h3>Bases de connaissance</h3>
                            <small>Guides, procédures et bonnes pratiques</small>
                        </div>
                    </li>
                    <li class="guest__item">
                        <div class="icon icon--square icon-title">
                            <i class="fa-regular fa-square-check"></i>
                        </div>
                        <div>
                            <h3>Outils et suivis</h3>
                            <small>Checklists, pickings et reporting</small>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <section class="form__section">

            <div class="form__header">

                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div>
                    <h2 class="form__title">Content de vous revoir</h2>

                    <p class="form__description">
                        Veuillez vous connecter à votre compte
                    </p>
                </div>
            </div>

            <div class="form__content">

                <x-forms.input
                    name="email"
                    label="Email"
                    placeholder="john.doe@econocom.com"
                    required
                />

                <x-forms.input
                    type="password"
                    name="password"
                    label="Mot de passe"
                    placeholder="Bonjour1234!"
                    required
                />

                <x-forms.boolean-checkbox
                    name="remember"
                    label="Se souvenir de moi ?"
                />

                <button
                    type="submit"
                    class="header__link button button--primary"
                >
                    <i class="fa-solid fa-lock"></i>
                    <span>Se connecter</span>
                </button>


            </div>

        </section>

    </form>
</x-layouts.guest>
