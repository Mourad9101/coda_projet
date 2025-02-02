import { getProducts } from "../services/product.js";
import { addToCart } from "../components/cart.js";

export const refreshCatalog = async (page = 1) => {
    const catalogContainer = document.querySelector('#catalog-container');
    const paginationContainer = document.querySelector('#pagination-container');

    console.log(" refreshCatalog() exécuté !");

    const searchInput = document.querySelector('#search-input');
    const search = searchInput ? searchInput.value.trim() : '';

    const activeCategory = document.querySelector('.category-link.active');
    const category = activeCategory ? activeCategory.dataset.id : null;



    const data = await getProducts(page, search, category);

    if (!data || !data.products || data.products.length === 0) {
        catalogContainer.innerHTML = '<p class="text-center text-muted">Aucun produit trouvé.</p>';
        paginationContainer.innerHTML = '';
        return;
    }

    let productsHTML = data.products.map(product => {
        let imagePath;
        if (product.image) {
            let cleanImagePath = product.image.replace(/^\/+|\/+$/g, '');
    
            imagePath = `/CODA_PROJET/mvc/uploads/${cleanImagePath}`;
        } else {
            console.warn(`⚠️ Image manquante pour ${product.name}`);
            imagePath = '/CODA_PROJET/assets/img/default.png';
        }
    
        console.log(`Image chargée pour ${product.name} :`, imagePath);
    
        const today = new Date().toISOString().split("T")[0];
        const isPromo = product.promo_price && product.promo_end && product.promo_end >= today;
        const priceDisplay = isPromo
            ? `<p class="text-danger fw-bold">🔥 Promo : ${product.promo_price} € 
               <span class="text-muted text-decoration-line-through">${product.price} €</span></p>`
            : `<p class="text-success fw-bold">${product.price} €</p>`;
    
        return `
        <div class="col-md-4">
            <div class="card product-card mb-4">
                <img src="${imagePath}" class="card-img-top" alt="${product.name}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description}</p>
                    ${priceDisplay}
                    <button class="btn btn-warning add-to-cart" data-id="${product.id}">Ajouter au panier</button>
                </div>
            </div>
        </div>
        `;
    }).join('');
    

    catalogContainer.innerHTML = productsHTML;
    console.log(' Produits insérés dans #catalog-container');

    paginationContainer.innerHTML = getPagination(data.totalPages, page);
    handlePaginationNavigation();
    handleAddToCart();
};

const getPagination = (totalPages, currentPage) => {
    let paginationHTML = `<nav aria-label="Page navigation"><ul class="pagination justify-content-center">`;

    if (currentPage > 1) {
        paginationHTML += `<li class="page-item"><a class="page-link pagination-btn" href="#" data-page="${currentPage - 1}">Précédent</a></li>`;
    }

    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link pagination-btn" href="#" data-page="${i}">${i}</a>
        </li>`;
    }

    if (currentPage < totalPages) {
        paginationHTML += `<li class="page-item"><a class="page-link pagination-btn" href="#" data-page="${currentPage + 1}">Suivant</a></li>`;
    }

    paginationHTML += `</ul></nav>`;
    return paginationHTML;
};

const handlePaginationNavigation = () => {
    document.querySelectorAll('.pagination-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const page = parseInt(e.target.dataset.page);
            await refreshCatalog(page);
        });
    });
};

document.querySelector('#search-input')?.addEventListener('input', async (e) => {
    console.log('Recherche mise à jour :', e.target.value.trim());
    await refreshCatalog(1);
});

document.querySelectorAll('.category-link').forEach(category => {
    category.addEventListener('click', async (e) => {
        e.preventDefault();
        document.querySelectorAll('.category-link').forEach(cat => cat.classList.remove('active'));
        e.target.classList.add('active');

        const categoryId = e.target.dataset.id;
        console.log('Catégorie sélectionnée :', categoryId);
        await refreshCatalog(1);
    });
});

const handleAddToCart = () => {
    console.log("Activation des boutons 'Ajouter au panier'...");

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.replaceWith(button.cloneNode(true));
    });

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = e.target.dataset.id;
            console.log(`Clic sur le bouton "Ajouter au panier" pour le produit ${productId}`);
            await addToCart(productId);
        });
    });
};

document.addEventListener("DOMContentLoaded", () => {
    refreshCatalog();
});
