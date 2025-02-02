<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h1 class="text-center mb-4">Connexion Admin</h1>
                <form id="login-form">
    <div class="mb-3">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <div id="errors"></div> 
    <button type="button" id="valid-login-btn" class="btn btn-primary w-100">Se connecter</button>
</form>

<script type="module">
    import { login } from "../assets/services/login.js";
    document.addEventListener('DOMContentLoaded', () => {
    const validLoginBtn = document.querySelector('#valid-login-btn');
    const loginForm = document.querySelector('#login-form');
    const errorElement = document.querySelector('#errors');

    if (!validLoginBtn || !loginForm || !errorElement) {
        console.error('Un ou plusieurs éléments du DOM manquent.');
        return;
    }

    validLoginBtn.addEventListener('click', async () => {
        if (!loginForm.checkValidity()) {
            console.log('Formulaire invalide');
            loginForm.reportValidity();
            return;
        }

        const username = loginForm.elements['username'].value;
        const password = loginForm.elements['password'].value;
        
        try {
            const response = await fetch('../controller/login.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new URLSearchParams({
                    username: username,
                    password: password,
                }),
            });

            const loginResult = await response.json();

            if (loginResult.authentication) {
                console.log('Connexion réussie');
                document.location.href = '../index.php?component=users';
            } else if (loginResult.errors) {
                console.log('Erreurs retournées par le serveur :', loginResult.errors);
                const errors = loginResult.errors.map(
                    (error) => `<div class="alert alert-danger" role="alert">${error}</div>`
                );
                errorElement.innerHTML = errors.join('');
            }
        } catch (error) {
            console.error('Erreur lors de la tentative de connexion :', error);
            errorElement.innerHTML = '<div class="alert alert-danger">Erreur inattendue. Veuillez réessayer.</div>';
        }
    });
});

    
</script>

