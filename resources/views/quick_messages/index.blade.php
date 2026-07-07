<x-layouts.fullscreen>
    <x-slot:title>
        Messages rapides
    </x-slot:title>

    <div x-data="quickMessages(
        @js($projects),
        @js($languages),
        @js($data)
    )">
        <div id="quick-messages-container">

            <header id="header-container-fix">
                <div class="header-project">
                    <div id="header__projects" class="header-project__settings">
                        <template x-for="p in projects" :key="'project-' + p.id">
                            <button type="button" @click="selectProject(p.id)"
                                :class="projectId === p.id ? 'active' : 'inactive'" x-text="p.label">
                            </button>
                        </template>
                    </div>

                    <h1>messages rapides</h1>

                    <div id="header__languages" class="header-project__settings">
                        <template x-for="l in projectLanguages()" :key="'language-' + l.language_id">
                            <button type="button" @click="languageId = l.language_id"
                                :class="languageId === l.language_id ? 'active' : 'inactive'" x-text="l.code">
                            </button>
                        </template>
                    </div>
                </div>
            </header>

            <main id="quick-messages">
                <template x-for="category in categories()" :key="category.category_id">
                    <x-quick-messages.category />
                </template>
            </main>

            <div x-text="toast"></div>

            <div>
                <a :href="`{{ route('messages.create') }}?project_id=${projectId}`">
                    +
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/pages/quick-messages.js')
    @endpush
</x-layouts.fullscreen>
