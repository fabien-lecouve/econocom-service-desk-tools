window.quickMessages = function (projects, languagesByProject, data) {
    return {
        projects,
        languagesByProject,
        data,

        projectId: projects[0]?.id ?? null,
        languageId: null,
        lastMessage: null,
        toast: '',

        init() {
            this.languageId = this.projectLanguages()[0]?.language_id ?? null;
        },

        selectProject(id) {
            this.projectId = id;
            this.languageId = this.projectLanguages()[0]?.language_id ?? null;

            // Évite de recopier un message appartenant à l'ancien projet.
            this.lastMessage = null;
        },

        async selectLanguage(id) {
            this.languageId = id;

            if (this.lastMessage) {
                await this.copy(this.lastMessage);
            }
        },

        categories() {
            return this.data?.[this.projectId] ?? [];
        },

        projectLanguages() {
            return this.languagesByProject?.[this.projectId] ?? [];
        },

        getSelectedLanguage() {
            return this.projectLanguages().find(
                language => language.language_id === this.languageId
            ) ?? null;
        },

        getSelectedProject() {
            return this.projects.find(
                project => project.id === this.projectId
            ) ?? null;
        },

        replaceVariables(text) {
            const project = this.getSelectedProject();
            const language = this.getSelectedLanguage();

            const variables = {
                external_phone: language?.external_phone_override || project?.external_phone || '',
                internal_phone: language?.internal_phone_override || project?.internal_phone || '',
                email: project?.email || '',
            };

            return Object.entries(variables).reduce(
                (result, [key, value]) => result.replaceAll(`{${key}}`, value),
                text ?? ''
            );
        },

        getMessageContent(message) {
            const selectedContent = message.content?.[this.languageId];

            if (selectedContent?.trim()) {
                return selectedContent;
            }

            // Cherche selon l’ordre des langues du projet.
            for (const language of this.projectLanguages()) {
                const content = message.content?.[language.language_id];

                if (content?.trim()) {
                    return content;
                }
            }

            // Sécurité si une traduction existe mais que sa langue
            // n’est plus configurée sur le projet.
            return Object.values(message.content ?? {}).find(
                content => content?.trim()
            ) ?? '';
        },

        getFormattedMessage(message) {
            const lang = this.getSelectedLanguage();

            if (!lang) {
                return '';
            }

            const salutation = this.replaceVariables(lang.salutation);
            const closing = this.replaceVariables(lang.closing);
            const signature = this.replaceVariables(lang.signature);

            const content = this.replaceVariables(
                this.getMessageContent(message)
            );

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
            this.lastMessage = message;

            try {
                await navigator.clipboard.writeText(
                    this.getFormattedMessage(message)
                );

                this.showToast('Copié');
            } catch (error) {
                this.showToast('Erreur copie');
            }
        },

        showToast(message) {
            this.toast = message;

            setTimeout(() => {
                this.toast = '';
            }, 1000);
        }
    };
};
