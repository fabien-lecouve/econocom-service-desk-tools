document.addEventListener('alpine:init', () => {
    Alpine.data('messagePreview', (message, colors, messageTypeColorSettings, oldValues = {}) => ({
        colors,
        messageTypeColorSettings,

        label: oldValues.label ?? message?.label,
        messageTypeId: oldValues.message_type_id ?? message?.message_type_id ?? null,

        fontColorId: oldValues.font_color_id ?? message?.font_color_id ?? null,
        backgroundColorId: oldValues.background_color_id ?? message?.background_color_id ?? null,
        borderTopColorId: oldValues.border_top_color_id ?? message?.border_top_color_id ?? null,

        get defaultMessageSettingColor() {
            return this.messageTypeColorSettings.find(
                setting => setting.message_type_id === Number(this.messageTypeId)
            ) ?? null;
        },

        get fontColor() {
            const color = this.colors.find(
                color => color.id === Number(this.fontColorId)
            );

            return color?.hex ?? this.defaultMessageSettingColor?.font_color?.hex ?? null;
        },

        get bgColor() {
            const color = this.colors.find(
                color => color.id === Number(this.backgroundColorId)
            );

            return color?.hex ?? this.defaultMessageSettingColor?.background_color?.hex ?? null;
        },

        get borderTopColor() {
            const color = this.colors.find(
                color => color.id === Number(this.borderTopColorId)
            );

            const hex = color?.hex ?? this.defaultMessageSettingColor?.border_top_color?.hex;

            return hex ? `4px solid ${hex}` : null;
        }
    }));
});