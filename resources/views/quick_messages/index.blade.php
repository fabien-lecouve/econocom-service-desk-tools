<x-layouts.fullscreen>
    <x-slot:title>
        Messages rapides
    </x-slot:title>

    <div
        x-data="quickMessages(
            {{ Js::from($projects) }},
            {{ Js::from($selectedProjectId) }}
        )"
    >
        <div class="quick-messages">

            <header class="header">
                <div class="header__content">
                    <div class="header__projects">
                        <template x-for="project in projects" :key="project.id">
                            <button 
                                type="button"
                                class="quick__button header__button"
                                :class="selectedProjectId === project.id ? 'active' : 'inactive'"
                                @click=setProjectId(project.id)
                                x-text="project.label">
                            </button>
                        </template>
                    </div>

                    <div class="header__languages">
                        <template x-for="setting in filteredLanguages()" :key="setting.language_id">
                            <button 
                                type="button"
                                class="quick__button header__button"
                                :class="selectedLanguageId === setting.language_id ? 'active' : 'inactive'"
                                @click=setLanguageId(setting.language_id)
                                x-text="setting.language.code">
                            </button>
                        </template>
                    </div>
                </div>
            </header>

            <main class="quick-messages__content">
                <template x-for="category in categories()" :key="category.id">
                    <x-quick-messages.category />
                </template>
            </main>

        </div>
    </div>

</x-layouts.fullscreen>
