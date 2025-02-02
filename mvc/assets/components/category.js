import { refreshCatalog } from './catalog.js';

export const handleCategoryNavigation = () => {
    const categoryLinks = document.querySelectorAll('.category-link');

    categoryLinks.forEach(link => {
        link.addEventListener('click', async (e) => {
            e.preventDefault();
            const categoryId = e.target.dataset.category;
            await refreshCatalog(1, categoryId);
        });
    });
};
