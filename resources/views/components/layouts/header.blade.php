@props([
    'title',
    'breadcrumbs' => [],
    'actions' => []
    ])

<header class="main__header header">
    <div class="header__heading">

        <h1 class="header__title">{{ $title }}</h1>

        @if ($breadcrumbs)
            <nav class="breadcrumb" aria-label="Fil d'Ariane">
                <ol class="breadcrumb__list">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb__item">
                            @if (isset($breadcrumb['link']))
                                <a class="breadcrumb__link" href="{{ $breadcrumb['link'] }}">
                                    {{ $breadcrumb['title'] }}
                                </a>
                            @else
                                <span class="breadcrumb__span" aria-current="page">
                                    {{ $breadcrumb['title'] }}
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

    </div>

    @if ($actions)
        <div class="header__actions">
            @foreach ($actions as $action)

                @can($action['policy'], $action['model'])
                    @if ($action['type'] === 'link')
                        <a
                            @class([
                                'header__link',
                                'button',
                                $action['class'] ?? '',
                            ])
                            href="{{ $action['link'] }}"
                        >
                            @if (isset($action['icon']))
                                <i class="{{ $action['icon'] }}"></i>
                            @endif

                            <span>{{ $action['label'] }}</span>
                        </a>
                    @else
                        <button
                            type="{{ $action['type'] }}"
                            form="{{ $action['form'] }}"
                            @class([
                                'header__link',
                                'button',
                                $action['class'] ?? '',
                            ])
                        >
                            @if (isset($action['icon']))
                                <i class="{{ $action['icon'] }}"></i>
                            @endif

                            <span>{{ $action['label'] }}</span>
                        </button>
                    @endif
                @endcan

            @endforeach
        </div>
    @endif
</header>
