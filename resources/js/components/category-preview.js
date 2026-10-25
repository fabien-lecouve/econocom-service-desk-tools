document.addEventListener('alpine:init', () => {
    Alpine.data('categoryPreview', (category, colors, categoryTypeColorSetting, oldValues = {}) => ({
        colors,
        categoryTypeColorSetting: categoryTypeColorSetting,

        label: oldValues.label ?? category?.label,

        fontColorId: oldValues.font_color_id ?? category?.font_color_id ?? null,
        backgroundColorId: oldValues.background_color_id ?? category?.background_color_id ?? null,
        borderTopColorId: oldValues.border_top_color_id ?? category?.border_top_color_id ?? null,

        get fontColor() {
            const color = this.colors.find(
                color => color.id === Number(this.fontColorId)
            );

            return color?.hex ?? this.categoryTypeColorSetting?.font_color?.hex ?? null;
        },

        get bgColor() {
            const color = this.colors.find(
                color => color.id === Number(this.backgroundColorId)
            );

            return color?.hex ?? this.categoryTypeColorSetting?.background_color?.hex ?? null;
        },

        get borderTopColor() {
            const color = this.colors.find(
                color => color.id === Number(this.borderTopColorId)
            );

            const hex = color?.hex ?? this.categoryTypeColorSetting?.border_top_color?.hex;

            return hex ? `4px solid ${hex}` : null;
        }
    }));
});