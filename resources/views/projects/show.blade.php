<x-layouts.dashboard>
    <x-slot:title>
        {{ $project->label }}
    </x-slot:title>

    <header class="main__header header">
        <h1 class="header__title">{{ $project->label }}</h1>
        <a href="{{ route('quick-messages.index', ['project' => $project]) }}">Vers les messages rapides -></a>
    </header>

    <div class="main__content" id="project-show-container">

        <section class="section">

            <h2 class="section__title">informations générales</h2>

            <div class="section__content">

                <p>Nom : {{ $project->label }}</p>
                <p>Téléphone : {{ $project->phone }}</p>

                <div class="row">
                    @foreach ($project->projectLanguageSettings as $setting)
                    <div class="row__card">
                        <h3>Signature {{ $setting->language->label }} :</h3>

                        <p>{!! nl2br(e($setting->signature)) !!}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </section>

    </div>

</x-layouts.dashboard>
