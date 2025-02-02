export const getProducts = async (currentPage = 1, search = '', category = null) => {
    try {
        console.log(` Requête AJAX envoyée : page=${currentPage}, search=${search}, category=${category}`);

        const params = new URLSearchParams({ page: currentPage });

        if (search && search.trim() !== '') params.append('search', search);
        if (category && category !== "null" && category !== null) params.append('category', category);

        const fullURL = `/CODA_PROJET/mvc/controller/catalog.php?${params.toString()}`;
        console.log('Nouvelle URL appelée par fetch :', fullURL);

        const response = await fetch(fullURL, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`Erreur HTTP ! Statut : ${response.status}`);
        }

        const data = await response.json();
        console.log('Réponse AJAX reçue :', data);

        if (!data.products || data.products.length === 0) {
            console.warn("⚠️ Aucun produit trouvé !");
        }

        return data;

    } catch (error) {
        console.error('Erreur lors de la récupération des produits :', error);
        return { products: [], totalPages: 0 };
    }
};
