document.addEventListener('alpine:init', () => {
    Alpine.data('categorySelector', (categories, initialCategoryId) => ({
        // 1. Données
        categories: categories,

        // 2. État du composant
        levels: [],
        selected: [],
        selectedCategoryId: '',
        initialCategoryId: initialCategoryId,

        // 3. Initialisation
        async init() {
            if (this.initialCategoryId) {
                const path = this.getCategoryPath(this.initialCategoryId);

                this.buildLevels(path);

                await this.$nextTick();

                this.selected = path;
                this.selectedCategoryId = this.initialCategoryId;
            } else {
                this.levels.push(this.categories);
            }
        },

        // 4. Méthodes utilitaires
        findCategory(categories, id) {
            const targetId = parseInt(id);

            for (const category of categories) {
                if (category.id === targetId) {
                    return category;
                }

                if (category.children?.length) {
                    const found = this.findCategory(
                        category.children,
                        targetId
                    );

                    if (found) {
                        return found;
                    }
                }
            }

            return null;
        },

        getCategoryPath(id) {
            const path = [];
            let category = this.findCategory(this.categories, id);

            while (category) {
                path.unshift(category.id);

                category = category.parent_id
                    ? this.findCategory(
                        this.categories,
                        category.parent_id
                    )
                    : null;
            }

            return path;
        },

        buildLevels(path) {
            let currentLevel = this.categories;

            for (const id of path) {
                this.levels.push(currentLevel);
                this.selected.push(id);

                const category = this.findCategory(currentLevel, id);

                currentLevel = category.children;
            }
        },

        // 5. Actions / logique principale
        handleCategoryChange(level, id, index) {
            this.levels.splice(index + 1);
            this.selected.splice(index + 1);

            if (id === '') {
                this.selectedCategoryId = this.selected[index - 1] ?? '';
                return;
            }

            const category = this.findCategory(level, id);

            this.selectedCategoryId = id;

            if (category.children.length) {
                this.levels.push(category.children);
            }
        }
    }));
});
