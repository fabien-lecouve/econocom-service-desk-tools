<x-layouts.guest>
    <x-slot:title>
        Se connecter
    </x-slot:title>

    <x-layouts.header
        title="Econocom"
    />

    <form
        method="POST"
        action="/login"
        class="form"
        >

        @csrf

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

                <x-forms.checkbox
                    name="remember"
                    :options="[1 => 'Se souvenir de moi ?']"
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
