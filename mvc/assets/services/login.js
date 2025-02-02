export const login = async (username, password) => {
    const formData = new URLSearchParams();
    formData.append('username', username);
    formData.append('password', password);

    const response = await fetch('../index.php?component=login', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
        method: 'POST',
        body: formData,
    });

    if (!response.ok) {
        throw new Error('Erreur réseau ou serveur');
    }

    return await response.json();
};
