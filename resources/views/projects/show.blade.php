<x-layouts.dashboard>
    <x-slot:title>
        {{ $project->label }}
    </x-slot:title>

    <header class="main__header header">
        <div class="header__heading">
            <p class="header__subtitle">Projet sélectionné</p>
            <h1 class="header__title">{{ $project->label }}</h1>
        </div>

        <div class="header__actions">
            <a
                href="{{ route('projects.edit', ['project' => $project]) }}"
                class="header__link"
            >
                Modifier le projet
            </a>

            <a href="{{ route('quick-messages.index', ['project' => $project]) }}"
                class="header__link header__link--primary">
                Messages rapides
            </a>
        </div>
    </header>

    <div class="main__content" id="project-show-container">

        {{-- <section class="project-card">
            <div class="project-card__identity">
                <div class="project-card__logo-placeholder">
                    Logo
                </div>

                <p class="project-card__code">
                    {{ $project->code ?? $project->label }}
                </p>
            </div>

            <div class="project-card__content">
                <div class="project-card__heading">
                    <h2 class="project-card__title">
                        {{ $project->label }}
                    </h2>

                    <span class="project-card__status">
                        Actif
                    </span>
                </div>

                <div class="project-card__details">
                    <div class="project-card__detail">
                        <p class="project-card__label">Téléphone</p>

                        <p class="project-card__value">
                            {{ $project->phone ?? '01 56 88 12 34' }}
                        </p>
                    </div>

                    <div class="project-card__detail">
                        <p class="project-card__label">Email support, récupérer champ mail projet</p>

                        <a
                            href="mailto:support.{{ $project->code ?? 'projet' }}@econocom.com"
                            class="project-card__link"
                        >
                            support.{{ $project->code ?? 'projet' }}@econocom.com
                        </a>
                    </div>

                    <div class="project-card__detail">
                        <p class="project-card__label">
                            Responsable côté client
                        </p>

                        <p class="project-card__value">
                            Pierre Martin
                        </p>
                    </div>
                </div>
            </div>
        </section> --}}

        <div class="project-grid">

            <section class="section">
                <div class="section__header">
                    <h2 class="section__title">
                        Signatures par langue
                    </h2>
                </div>

                <div class="section__content signature-list">
                    @forelse ($project->projectLanguageSettings as $setting)
                        <article class="signature-card">
                            <div class="signature-card__header">
                                <h3 class="signature-card__title">
                                    {{ $setting->language->label }}
                                </h3>

                                {{-- Route fictive à remplacer lorsqu'elle existera --}}
                                {{-- <a
                                    href="#"
                                    class="signature-card__button"
                                >
                                    Modifier
                                </a> --}}
                            </div>

                            <div class="signature-card__content">
                                <p>
                                    {!! nl2br(e($setting->signature)) !!}
                                </p>
                            </div>
                        </article>
                    @empty
                        <article class="signature-card">
                            <div class="signature-card__header">
                                <h3 class="signature-card__title">
                                    Français
                                </h3>

                                <a href="#" class="signature-card__button">
                                    Modifier
                                </a>
                            </div>

                            <div class="signature-card__content">
                                <p>
                                    Cordialement,<br>
                                    L'équipe Econocom Service Desk<br><br>
                                    {{ $project->phone ?? '01 56 88 12 34' }}<br>
                                    support.{{ $project->code ?? 'projet' }}@econocom.com
                                </p>
                            </div>
                        </article>

                        <article class="signature-card">
                            <div class="signature-card__header">
                                <h3 class="signature-card__title">
                                    English
                                </h3>

                                <a href="#" class="signature-card__button">
                                    Modifier
                                </a>
                            </div>

                            <div class="signature-card__content">
                                <p>
                                    Best regards,<br>
                                    Econocom Service Desk Team<br><br>
                                    {{ $project->phone ?? '01 56 88 12 34' }}<br>
                                    support.{{ $project->code ?? 'projet' }}@econocom.com
                                </p>
                            </div>
                        </article>
                    @endforelse
                </div>
            </section>

            <section class="section">
                <div class="section__header">
                    <h2 class="section__title">
                        Informations projet
                    </h2>
                </div>

                <dl class="section__content information-list">
                    <div class="information-row">
                        <dt>Code projet</dt>
                        <dd>{{ $project->code ?? 'LACOSTE' }}</dd>
                    </div>

                    <div class="information-row">
                        <dt>Nom complet</dt>
                        <dd>{{ $project->label }}</dd>
                    </div>

                    @if ($project->internal_phone)
                        <div class="information-row">
                            <dt>Téléphone interne</dt>
                            <dd>{{ $project->internal_phone }}</dd>
                        </div>
                    @endif

                    @if ($project->external_phone)
                        <div class="information-row">
                            <dt>Téléphone externe</dt>
                            <dd>{{ $project->external_phone }}</dd>
                        </div>
                    @endif

                    <div class="information-row">
                        <dt>Email support</dt>
                        <dd>{{ $project->email ?? '' }}
                        </dd>
                    </div>

                    <div class="information-row">
                        <dt>Fuseau horaire</dt>
                        <dd>Europe/Paris</dd>
                    </div>

                    <div class="information-row">
                        <dt>Langues disponibles</dt>

                        <dd>
                            @forelse ($project->projectLanguageSettings as $setting)
                                {{ $setting->language->label }}@if (!$loop->last)
                                    ,
                                @endif
                            @empty
                                Français, English
                            @endforelse
                        </dd>
                    </div>

                    <div class="information-row">
                        <dt>Techniciens associés</dt>
                        <dd>12</dd>
                    </div>

                    <div class="information-row">
                        <dt>Date de création</dt>
                        <dd>
                            {{ $project->created_at?->format('d/m/Y') ?? '15/03/2023' }}
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="section">
                <div class="section__header">
                    <h2 class="section__title">
                        Accès rapides
                    </h2>
                </div>

                <div class="section__content quick-links">
                    <a href="{{ route('categories.index', $project) }}" class="quick-link">
                        Les catégories
                    </a>

                    <a href="{{ route('categories.create', ['project' => $project]) }}" class="quick-link">
                        Créer une catégorie
                    </a>

                    <a href="{{ route('messages.index', $project) }}" class="quick-link">
                        Les messages
                    </a>

                    <a href="{{ route('messages.create', ['project' => $project]) }}" class="quick-link">
                        Créer un message
                    </a>

                </div>
            </section>

            <section class="section">
                <div class="section__header">
                    <h2 class="section__title">
                        Statistiques ce mois
                    </h2>
                </div>

                <div class="section__content statistics">
                    <div class="statistic">
                        <span class="statistic__value">154</span>
                        <span class="statistic__label">
                            Messages copiés
                        </span>
                    </div>

                    <div class="statistic">
                        <span class="statistic__value">87</span>
                        <span class="statistic__label">
                            Tickets traités
                        </span>
                    </div>

                    <div class="statistic">
                        <span class="statistic__value">12</span>
                        <span class="statistic__label">
                            Messages favoris
                        </span>
                    </div>

                    <div class="statistic">
                        <span class="statistic__value">3</span>
                        <span class="statistic__label">
                            Catégories utilisées
                        </span>
                    </div>
                </div>
            </section>

        </div>

    </div>
</x-layouts.dashboard>
