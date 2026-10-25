document.addEventListener('alpine:init', () => {
    Alpine.data('colorSelector', (colors, selectedColorId = null) => ({
        colors: colors,
        selectedColorId: selectedColorId === null || selectedColorId === ''
            ? null
            : Number(selectedColorId),
        open: false,
        openUp: false,

        toggle() {
            if (!this.open) {
                const rect = this.$refs.button.getBoundingClientRect();

                const spaceBelow = window.innerHeight - rect.bottom;
                const spaceAbove = rect.top;

                this.openUp = spaceBelow < 300 && spaceAbove > spaceBelow;
            }

            this.open = !this.open;
        },
        close() {
            this.open = false;
        },
        selectColor(id) {
            this.close();

            if(!id) {
                this.selectedColorId = null;
                return;
            }
            
            this.selectedColorId = id;
        },
        get selectedColor() {
            return this.colors.find(color => color.id === this.selectedColorId) ?? null;
        }
    }))
})