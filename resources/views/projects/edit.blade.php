<x-layouts.dashboard>
    <x-slot:title>
        Modifier {{ $project->label }}
    </x-slot:title>

    <header class="main__header header">
        <div class="header__heading">
            <p class="header__subtitle">
                Administration du projet
            </p>

            <h1 class="header__title">
                Modifier {{ $project->label }}
            </h1>
        </div>

        <div class="header__actions">
            <a href="{{ route('projects.show', $project) }}" class="header__link">
                Retour au projet
            </a>
        </div>
    </header>

    <div class="main__content">
        <form
            class="project-edit"
            method="POST"
            action="{{ route('projects.update', $project) }}"
        >
            @csrf
            @method('PUT')

            <section class="section">
                <div class="section__header">
                    <div>
                        <p class="section__subtitle">
                            Configuration générale
                        </p>

                        <h2 class="section__title">
                            Informations du projet
                        </h2>
                    </div>
                </div>

                <div class="section__content">
                    <div class="project-edit__grid">
                        <div class="form__group project-edit__field--full">
                            <label class="form__label" for="label">
                                Nom du projet
                            </label>

                            <input
                                id="label"
                                class="form__input @error('label') form__input--error @enderror"
                                type="text"
                                name="label"
                                value="{{ old('label', $project->label) }}"
                                required
                            >

                            @error('label')
                                <p class="form__error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form__group">
                            <label class="form__label" for="internal_phone">
                                Téléphone interne
                            </label>

                            <input
                                id="internal_phone"
                                class="form__input @error('internal_phone') form__input--error @enderror"
                                type="text"
                                name="internal_phone"
                                value="{{ old('internal_phone', $project->internal_phone) }}"
                                placeholder="Ex. 1234"
                            >

                            @error('internal_phone')
                                <p class="form__error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form__group">
                            <label class="form__label" for="external_phone">
                                Téléphone externe
                            </label>

                            <input
                                id="external_phone"
                                class="form__input @error('external_phone') form__input--error @enderror"
                                type="text"
                                name="external_phone"
                                value="{{ old('external_phone', $project->external_phone) }}"
                                placeholder="Ex. 01 23 45 67 89"
                            >

                            @error('external_phone')
                                <p class="form__error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form__group project-edit__field--full">
                            <label class="form__label" for="email">
                                Email support
                            </label>

                            <input
                                id="email"
                                class="form__input @error('email') form__input--error @enderror"
                                type="email"
                                name="email"
                                value="{{ old('email', $project->email) }}"
                                placeholder="support@exemple.com"
                            >

                            @error('email')
                                <p class="form__error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            <section class="section">
                <div class="section__header">
                    <div>
                        <p class="section__subtitle">
                            Personnalisation
                        </p>

                        <h2 class="section__title">
                            Signatures par langue
                        </h2>
                    </div>
                </div>

                <div class="section__content">
                    <div class="project-edit__languages">
                        @foreach ($languages as $index => $language)
                            @php
                                $setting = $project->projectLanguageSettings
                                    ->firstWhere('language_id', $language->id);
                            @endphp

                            <article class="project-edit__language">
                                <input
                                    type="hidden"
                                    name="languages[{{ $index }}][language_id]"
                                    value="{{ $language->id }}"
                                >

                                <header class="project-edit__language-header">
                                    <div>
                                        <p class="project-edit__language-code">
                                            {{ strtoupper($language->code) }}
                                        </p>

                                        <h3 class="project-edit__language-title">
                                            {{ $language->label }}
                                        </h3>
                                    </div>
                                </header>

                                <div class="project-edit__language-content">
                                    <div class="form__group">
                                        <label
                                            class="form__label"
                                            for="signature_{{ $language->id }}"
                                        >
                                            Signature
                                        </label>

                                        <textarea
                                            id="signature_{{ $language->id }}"
                                            class="form__textarea @error("languages.$index.signature") form__textarea--error @enderror"
                                            name="languages[{{ $index }}][signature]"
                                            rows="10"
                                            placeholder="Saisissez la signature utilisée pour cette langue"
                                        >{{ old("languages.$index.signature", $setting?->signature) }}</textarea>

                                        @error("languages.$index.signature")
                                            <p class="form__error">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="project-edit__overrides">
                                        <div class="form__group">
                                            <label
                                                class="form__label"
                                                for="internal_phone_override_{{ $language->id }}"
                                            >
                                                Téléphone interne spécifique
                                            </label>

                                            <input
                                                id="internal_phone_override_{{ $language->id }}"
                                                class="form__input @error("languages.$index.internal_phone_override") form__input--error @enderror"
                                                type="text"
                                                name="languages[{{ $index }}][internal_phone_override]"
                                                value="{{ old("languages.$index.internal_phone_override", $setting?->internal_phone_override) }}"
                                                placeholder="Laisser vide pour utiliser la valeur générale"
                                            >

                                            @error("languages.$index.internal_phone_override")
                                                <p class="form__error">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <div class="form__group">
                                            <label
                                                class="form__label"
                                                for="external_phone_override_{{ $language->id }}"
                                            >
                                                Téléphone externe spécifique
                                            </label>

                                            <input
                                                id="external_phone_override_{{ $language->id }}"
                                                class="form__input @error("languages.$index.external_phone_override") form__input--error @enderror"
                                                type="text"
                                                name="languages[{{ $index }}][external_phone_override]"
                                                value="{{ old("languages.$index.external_phone_override", $setting?->external_phone_override) }}"
                                                placeholder="Laisser vide pour utiliser la valeur générale"
                                            >

                                            @error("languages.$index.external_phone_override")
                                                <p class="form__error">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <div class="project-edit__actions">
                <a
                    href="{{ route('projects.show', $project) }}"
                    class="project-edit__cancel"
                >
                    Annuler
                </a>

                <button class="project-edit__submit" type="submit">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
