
<header class="sidebar-mobile">
    <a href="{{ url('/') }}" class="sidebar-mobile__brand">
        econocom
    </a>

    <button
        type="button"
        class="sidebar-mobile__toggle"
        @click="sidebarOpen = true"
        aria-label="Ouvrir le menu"
        :aria-expanded="sidebarOpen.toString()"
        aria-controls="dashboard-sidebar"
    >
        <i class="fa-solid fa-bars"></i>
    </button>
</header>

<div
    class="sidebar-overlay"
    x-show="sidebarOpen"
    x-cloak
    x-transition.opacity
    @click="sidebarOpen = false"
    aria-hidden="true"
></div>

<aside
    id="dashboard-sidebar"
    class="sidebar"
    :class="{ 'sidebar--open': sidebarOpen }"
    :inert="!sidebarOpen && window.innerWidth < 1024"
>
    <nav class="sidebar__nav">

        <div class="sidebar__header">
            <a href="{{ url('/') }}" class="sidebar__brand">
                <h2 class="sidebar__brand-title">econocom</h2>
                <p class="sidebar__brand-subtitle">service desk tools</p>
            </a>

            <button
                type="button"
                class="sidebar__close"
                @click="sidebarOpen = false"
                aria-label="Fermer le menu"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="sidebar__content">

            <div class="sidebar-menu">
                <h3 class="sidebar-menu__title">Projets</h3>

                <ul class="sidebar-menu__list">
                    @foreach ($projects as $project)
                        <li class="sidebar-menu__item {{ request()->route('project')?->id === $project->id ? 'active' : '' }}">
                            <a
                                class="sidebar-menu__link"
                                href="{{ route('projects.show', $project) }}"
                            >
                                {{ $project->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <form
                class="sidebar__logout"
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button class="sidebar__logout-button" type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Déconnexion
                </button>
            </form>

        </div>
    </nav>
</aside>
