export const getCartItems = async () => {
    try {
        console.log(" Récupération des articles du panier...");

        const response = await fetch('/CODA_PROJET/mvc/controller/cart.php', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`Erreur HTTP : ${response.status}`);
        }

        const data = await response.json();
        console.log("Articles du panier récupérés :", data);
        return data;

    } catch (error) {
        console.error("Erreur lors de la récupération du panier :", error);
        return { cartItems: [], cartCount: 0 };
    }
};

export const clearCart = async () => {
    try {
        console.log("🗑️ Demande de vidage du panier...");

        const response = await fetch('/CODA_PROJET/mvc/controller/cart.php?action=clear', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`Erreur HTTP : ${response.status}`);
        }

        const data = await response.json();
        console.log("Panier vidé :", data);
        return data;

    } catch (error) {
        console.error("Erreur lors du vidage du panier :", error);
        return { success: false };
    }
};
