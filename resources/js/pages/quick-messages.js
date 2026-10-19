document.addEventListener('alpine:init', () => {
    Alpine.data('quickMessages', (projects, selectedProjectId) => ({
        projects: projects,
        messageTypes: {
            worknote: 'work_note',
            comment: 'comment',
            escalation: 'escalation'
        },
        selectedProjectId: selectedProjectId,
        selectedLanguageId: null,
        selectedMessage: null,

        setProjectId(id) {
            this.selectedProjectId = id;
            this.selectedLanguageId = this.currentProject.project_language_settings[0].language_id;
            this.selectedMessage = null;
        },
        setLanguageId(id) {
            this.selectedLanguageId = id;

            if (this.selectedMessage) {
                this.copy(this.selectedMessage)
            }
        },

        get currentProject() {
            return this.projects.find((p) => p.id === this.selectedProjectId);
        },

        get currentProjectLanguageSetting() {
            return this.currentProject.project_language_settings.find((setting) => setting.language_id === this.selectedLanguageId);
        },

        filteredLanguages() {
            return this.currentProject.project_language_settings;
        },

        categories() {
            return this.currentProject.categories;
        },

        getCategoryStyle(category) {
            const categoryColorSetting = this.currentProject.category_color_setting;

            let borderTopColor = category.border_top_color ? category.border_top_color.hex : categoryColorSetting.border_top_color?.hex;

            return {
                color: category.font_color ? category.font_color.hex : categoryColorSetting.font_color.hex,
                backgroundColor: category.background_color ? category.background_color.hex : categoryColorSetting.background_color.hex,
                borderTop: borderTopColor
                    ? `4px solid ${borderTopColor}`
                    : null,
            };
        },

        getMessageStyle(message) {
            const messageColorSettings = this.currentProject.message_type_color_settings;
            const messageColorSetting = messageColorSettings.find((m) => m.message_type_id === message.message_type_id)

            let borderTopColor = message.border_top_color ? message.border_top_color.hex : messageColorSetting.border_top_color?.hex;

            return {
                color: message.font_color ? message.font_color.hex : messageColorSetting.font_color.hex,
                backgroundColor: message.background_color ? message.background_color.hex : messageColorSetting.background_color.hex,
                borderTop: borderTopColor
                    ? `4px solid ${borderTopColor}`
                    : null,
            };
        },

        replaceVariables(text) {
            const variables = {
                external_phone: this.currentProjectLanguageSetting.external_phone_override || this.currentProject.external_phone || '',
                internal_phone: this.currentProjectLanguageSetting.internal_phone_override || this.currentProject.internal_phone || '',
                email: this.currentProject.email || '',
            };

            return Object.entries(variables).reduce(
                (result, [key, value]) => result.replaceAll(`{${key}}`, value),
                text ?? ''
            );
        },

        getFilledContent(message) {
            const selectedTranslation = message.translations.find((translation) => translation.language_id === this.selectedLanguageId);

            if (selectedTranslation?.content) {
                return selectedTranslation.content;
            }

            const fallbackTranslation = message.translations.find((translation) => translation.content);

            return fallbackTranslation?.content ?? '';
        },

        buildMessage(message) {
            const content = this.replaceVariables(this.getFilledContent(message));

            if (message.type.code === this.messageTypes.worknote) {
                return content;
            }

            const salutation = this.currentProjectLanguageSetting.language.setting.salutation;
            const closing = this.currentProjectLanguageSetting.language.setting.closing;

            if (message.type.code === this.messageTypes.escalation) {
                return `${salutation},\n\n${content}\n\n${closing},`;
            }

            const signature = this.replaceVariables(this.currentProjectLanguageSetting.signature);

            if (message.type.code === this.messageTypes.comment) {
                return `${salutation},\n\n${content}\n\n${closing},\n\n${signature}`;
            }
        },

        copy(message) {
            this.selectedMessage = message;

            const text = this.buildMessage(message);

            if (navigator.clipboard?.writeText) {
                return navigator.clipboard.writeText(text);
            }
        },

        init() {
            this.selectedLanguageId = this.currentProject.project_language_settings[0].language_id;
        }
    }))
})