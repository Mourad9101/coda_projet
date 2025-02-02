import { refreshCatalog } from './components/product.js';
import { updateCartCountUI } from './components/cart.js';

document.addEventListener('DOMContentLoaded', async () => {
    console.log(' Appel de refreshCatalog() depuis main.js');
    await refreshCatalog();

    console.log('🛒Mise à jour du compteur du panier...');
    await updateCartCountUI();
});
