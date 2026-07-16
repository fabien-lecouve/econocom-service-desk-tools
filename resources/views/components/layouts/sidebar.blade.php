<aside class="sidebar">

    <nav class="navbar">

        <a href="" class="navbar__item navbar__item--home">
            <h2>econocom</h2>
            <p>service desk tools</p>
        </a>

        <div class="navbar__item menu">

            <div class="menu__item">
                <h2>projets</h2>
                <ul>
                    @foreach ($projects as $project)
                        <li><a href="{{ route('projects.show', ['project' => $project]) }}">{{ $project->label }}</a>
                        </li>
                    @endforeach
                    <li><a href="{{ route('projects.create') }}">Créer un nouveau projet</a>
                    </li>
                </ul>
            </div>

            {{-- <div class="menu__item">
                <h2>base de connaissance</h2>
                <ul>
                    <li><a href="">Office 365</a></li>
                    <li><a href="">Poste de travail</a></li>
                </ul>
            </div> --}}

        </div>

    </nav>

</aside>
