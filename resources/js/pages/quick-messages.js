window.quickMessages = function (projects, languagesByProject, data) {
    return {
        projects,
        languagesByProject,
        data,

        projectId: projects[0]?.id ?? null,
        languageId: null,
        toast: '',

        init() {
            this.languageId = this.projectLanguages()[0]?.language_id ?? null;
        },

        selectProject(id) {
            this.projectId = id;
            this.languageId = this.projectLanguages()[0]?.language_id ?? null;
        },

        categories() {
            return this.data?.[this.projectId] ?? [];
        },

        projectLanguages() {
            return this.languagesByProject?.[this.projectId] ?? [];
        },

        getSelectedLanguage() {
            return this.projectLanguages().find(l => l.language_id === this.languageId) ?? null;
        },

        getFormattedMessage(message) {
            const lang = this.getSelectedLanguage();
            if (!lang) return '';

            const salutation = lang.salutation ?? '';
            const closing = lang.closing ?? '';
            const signature = lang.signature ?? '';
            const content = message.content?.[this.languageId] ?? '';

            switch (message.type) {
                case 'work_note':
                    return content;

                case 'escalation':
                    return `${salutation}\n\n${content}\n\n${closing}`;

                default:
                    return `${salutation}\n\n${content}\n\n${closing}\n${signature}`;
            }
        },

        async copy(message) {
            try {
                await navigator.clipboard.writeText(this.getFormattedMessage(message));
                this.toast = 'Copié';
            } catch (e) {
                this.toast = 'Erreur copie';
            }

            setTimeout(() => this.toast = '', 1000);
        }
    };
};