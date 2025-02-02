import { getCartItems } from "../services/cart.js";

const updateCartCount = (count) => {
    const cartCountElement = document.querySelector('#cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
    }
};

const updateCartCountUI = async () => {
    try {
        const response = await fetch('/CODA_PROJET/mvc/controller/cart.php', {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const data = await response.json();
        if (data.cartCount !== undefined) {
            updateCartCount(data.cartCount);
        }
    } catch (error) {
        console.error("Erreur lors de la mise à jour du compteur du panier :", error);
    }
};

export const addToCart = async (productId) => {
    console.log(` Ajout du produit ${productId} au panier...`);

    try {
        const response = await fetch('/CODA_PROJET/mvc/controller/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ productId })
        });

        const data = await response.json();
        console.log(' Réponse du serveur :', data);

        if (data.success) {
            updateCartCount(data.cartCount);
        } else {
            console.warn(' Erreur :', data.message);
        }

    } catch (error) {
        console.error('Erreur lors de l\'ajout au panier :', error);
    }
};

const displayCartItems = async () => {
    const cartContainer = document.querySelector("#cart-container");
    if (!cartContainer) return;

    const data = await getCartItems();

    if (data.cartItems.length === 0) {
        cartContainer.innerHTML = '<p class="text-center text-muted">Votre panier est vide.</p>';
        updateCartCount(0);
        updateCartTotal();
        return;
    }

    let cartHTML = data.cartItems.map(item => `
        <div class="col-md-12 cart-item d-flex align-items-center border-bottom py-3">
            <img src="http://localhost:8888/CODA_PROJET${item.image}" class="me-3 cart-item-img">
            <div class="flex-grow-1">
                <h5 class="cart-item-title">${item.name}</h5>
                <p class="cart-item-price text-success fw-bold">${item.price} €</p>
                <div class="quantity-control mt-2 d-flex align-items-center">
                    <button class="btn btn-secondary decrease-qty me-2" data-id="${item.id}">-</button>
                    <span class="cart-item-quantity mx-2">${item.quantity}</span>
                    <button class="btn btn-secondary increase-qty ms-2" data-id="${item.id}">+</button>
                </div>
                <p class="cart-item-total mt-2">${(item.price * item.quantity).toFixed(2)} €</p>
            </div>
            <button class="btn btn-danger remove-from-cart ms-auto" data-id="${item.id}">Supprimer</button>
        </div>
    `).join('');

    cartContainer.innerHTML = cartHTML;
    updateCartTotal();
    updateCartCount(data.cartCount);

    setTimeout(() => {
        handleQuantityButtons();
        handleRemoveButtons();
    }, 100);
};

const updateCartTotal = () => {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        let price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('€', '').trim());
        let quantity = parseInt(item.querySelector('.cart-item-quantity').textContent);
        total += price * quantity;
    });

    document.querySelector("#cart-total").textContent = total.toFixed(2) + " €";
};

const handleQuantityButtons = () => {
    console.log(" Activation des boutons de quantité...");

    document.querySelectorAll('.increase-qty, .decrease-qty').forEach(button => {
        const clone = button.cloneNode(true);
        button.replaceWith(clone);
    });

    document.querySelectorAll('.increase-qty').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = e.target.dataset.id;
            console.log(` Augmenter la quantité du produit ${productId}`);
            await updateQuantity(productId, 1);
        });
    });

    document.querySelectorAll('.decrease-qty').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = e.target.dataset.id;
            console.log(` Diminuer la quantité du produit ${productId}`);
            await updateQuantity(productId, -1);
        });
    });
};

const updateQuantity = async (productId, change) => {
    try {
        const response = await fetch('/CODA_PROJET/mvc/controller/cart.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ productId, change })
        });

        const data = await response.json();
        console.log(' Mise à jour de la quantité :', data);

        if (data.success) {
            displayCartItems();
        } else {
            console.warn("Erreur lors de la mise à jour.");
        }
    } catch (error) {
        console.error("🔴 Erreur lors de la mise à jour :", error);
    }
};

const handleRemoveButtons = () => {
    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = e.target.dataset.id;
            console.log(`Suppression du produit ${productId} du panier.`);
            await removeFromCart(productId);
            displayCartItems();
        });
    });
};

const removeFromCart = async (productId) => {
    try {
        const response = await fetch('/CODA_PROJET/mvc/controller/cart.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ productId })
        });

        const data = await response.json();
        console.log(' Produit supprimé du panier :', data);

        if (data.success) {
            displayCartItems();
            updateCartCount(data.cartCount);
        } else {
            console.warn("⚠️ Erreur lors de la suppression du produit.");
        }
    } catch (error) {
        console.error(" Erreur lors de la suppression :", error);
    }
};

document.addEventListener("DOMContentLoaded", async () => {
    await displayCartItems();
    await updateCartCountUI();
});

export { displayCartItems, updateCartCountUI };
