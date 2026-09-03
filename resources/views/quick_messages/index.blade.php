<x-layouts.fullscreen>
    <x-slot:title>
        Messages rapides
    </x-slot:title>

    <div x-data="quickMessages(
        @js($projects),
        @js($languages),
        @js($data)
    )">
        <div class="quick-messages">

            <header class="header">
                <div class="header__content">
                    <div class="header__projects">
                        <template x-for="p in projects" :key="'project-' + p.id">
                            <button type="button" @click="selectProject(p.id)"
                                class="quick__button header__button"
                                :class="projectId === p.id ? 'active' : 'inactive'" x-text="p.label">
                            </button>
                        </template>
                    </div>

                    <div class="header__languages">
                        <template x-for="l in projectLanguages()" :key="'language-' + l.language_id">
                            <button type="button" @click="selectLanguage(l.language_id)"
                                class="quick__button header__button"
                                :class="languageId === l.language_id ? 'active' : 'inactive'" x-text="l.code">
                            </button>
                        </template>
                    </div>
                </div>
            </header>

            <main class="quick-messages__content">
                <template x-for="category in categories()" :key="category.category_id">
                    <x-quick-messages.category />
                </template>
            </main>

            <div x-text="toast"></div>

        </div>
    </div>

    @push('scripts')
        @vite('resources/js/pages/quick-messages.js')
    @endpush
</x-layouts.fullscreen>
