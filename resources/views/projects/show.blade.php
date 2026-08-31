<x-layouts.dashboard>
    <x-slot:title>
        {{ $project->label }}
    </x-slot:title>

    <x-layouts.header
        :title="$project->label"
        :breadcrumbs="[
            [
                'link' => route('projects.index'),
                'title' => 'Projets',
            ],
            [
                'title' => $project->label,
            ]
        ]"
        :actions="[
            [
                'type' => 'link',
                'link' => route('projects.edit', $project),
                'label' => 'Modifier le projet',
                'icon' => 'fa-solid fa-pen',
                'class' => 'button--primary'
            ]
        ]" />

    <div class="detail">

        <dl class="detail__section">

            <div class="detail__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-info"></i>
                </div>
                <h2 class="detail__title">Informations du projet</h2>
            </div>

            <div class="detail__content detail__content--4">

                <div class="detail__item detail__item--column">
                    <i class="fa-solid fa-barcode"></i>
                    <dt>Code projet</dt>
                    <dd>{{ $project->code }}</dd>
                </div>

                <div class="detail__item detail__item--column">
                    <i class="fa-solid fa-phone"></i>
                    <dt>Téléphone interne</dt>
                    <dd>{{ $project->internal_phone ?? 'Non communiqué' }}</dd>
                </div>

                <div class="detail__item detail__item--column">
                    <i class="fa-solid fa-phone"></i>
                    <dt>Téléphone externe</dt>
                    <dd>{{ $project->external_phone ?? 'Non communiqué' }}</dd>
                </div>

                <div class="detail__item detail__item--column">
                    <i class="fa-regular fa-envelope"></i>
                    <dt>Email support</dt>
                    <dd>{{ $project->email ?? 'Non communiqué' }}</dd>
                </div>

            </div>

        </dl>

        <section class="detail__section">

            <div class="detail__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <h2 class="detail__title">
                    Accès rapides
                </h2>
            </div>

            <div class="detail__content detail__content--5">

                <a href="{{ route('categories.index', $project) }}" class="card">
                    <div class="card__header">
                        <div class="card__icon">
                            <i class="fa-solid fa-folder"></i>
                        </div>

                        <h3 class="card__title">Catégories</h3>
                    </div>
                    <div class="card__content">
                        <p class="card__description">Gérer l'arborescence des catégories</p>
                        <div class="card__arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('categories.create', ['project' => $project]) }}" class="card">
                    <div class="card__header">
                        <div class="card__icon">
                            <i class="fa-solid fa-folder-plus"></i>
                        </div>

                        <h3 class="card__title">Nouvelle catégorie</h3>
                    </div>
                    <div class="card__content">
                        <p class="card__description">Créer une catégorie</p>

                        <div class="card__arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('messages.index', $project) }}" class="card">
                    <div class="card__header">
                        <div class="card__icon">
                            <i class="fa-solid fa-file"></i>
                        </div>

                        <h3 class="card__title">Messages</h3>
                    </div>
                    <div class="card__content">
                        <p class="card__description">Gérer l'arborescence des messages</p>

                        <div class="card__arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('messages.create', ['project' => $project]) }}" class="card">
                    <div class="card__header">
                        <div class="card__icon">
                            <i class="fa-solid fa-file-circle-plus"></i>
                        </div>

                        <h3 class="card__title">Nouveau message</h3>
                    </div>
                    <div class="card__content">
                        <p class="card__description">Créer un message</p>

                        <div class="card__arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('quick-messages.index', ['project' => $project]) }}" class="card" target="_blank">
                    <div class="card__header">
                        <div class="card__icon">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </div>

                        <h3 class="card__title">Messages rapides</h3>
                    </div>
                    <div class="card__content">
                        <p class="card__description">Accéder aux boutons cliquables</p>

                        <div class="card__arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </a>

            </div>
        </section>

        <section class="detail__section">

            <div class="detail__header">
                <div class="icon icon--round icon-title">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <h2 class="detail__title">
                    Paramètres des langues
                </h2>
            </div>

            <table class="table">
                <colgroup>
                    <col class="table__col--15">
                    <col class="table__col--45">
                    <col class="table__col--20">
                    <col class="table__col--20">
                </colgroup>
                <thead class="table__thead">
                    <tr>
                        <th>Langue</th>
                        <th>Signature</th>
                        <th>Téléphone interne spécifique</th>
                        <th>Téléphone externe spécifique</th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    @forelse ($project->projectLanguageSettings as $setting)
                        <tr>
                            <td><span class="badge">{{ strtoupper($setting->language->code) }}</span> {{ $setting->language->label}}</td>
                            <td>{!! nl2br(e($setting->signature)) !!}</td>
                            <td class="center">{{ $setting->internal_phone_override ?? 'Non communiqué' }}</td>
                            <td class="center">{{ $setting->external_phone_override ?? 'Non communiqué' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>Non communiqué</td>
                            <td>Non communiqué</td>
                            <td>Non communiqué</td>
                            <td>Non communiqué/td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </section>
    </div>

</x-layouts.dashboard>
