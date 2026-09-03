<aside class="sidebar">

    <nav class="sidebar__nav">

        <a href="" class="sidebar__brand">
            <h2 class="sidebar__brand-title">econocom</h2>
            <p class="sidebar__brand-subtitle">service desk tools</p>
        </a>

        <div class="sidebar__content">

            <div class="sidebar-menu">
                <h3 class="sidebar-menu__title">Projets</h3>

                <ul class="sidebar-menu__list">
                    @foreach ($projects as $project)
                        <li class="sidebar-menu__item {{ request()->route('project')?->id === $project->id ? 'active' : '' }}">
                            <a class="sidebar-menu__link" href="{{ route('projects.show', $project) }}">
                                {{ $project->label }}
                            </a>
                        </li>
                    @endforeach

                    {{-- <li class="sidebar-menu__item {{ request()->routeIs('projects.create') ? 'active' : '' }}">
                        <a class="sidebar-menu__link" href="{{ route('projects.create') }}">
                            <i class="fa-solid fa-plus"></i>
                            Créer un projet
                        </a>
                    </li> --}}
                </ul>
            </div>

            <form class="sidebar__logout" method="POST" action="{{ route('logout') }}">
                @csrf

                <button class="sidebar__logout-button" type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Déconnexion
                </button>
            </form>

        </div>

    </nav>

</aside>
