<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('css/connection.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Connexion à votre compte</h1>
        <p class="text-center text-gray-600 mb-6">Connectez-vous pour accéder à votre espace personnel.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="input-field" required>
            </div>
            <div class="mb-4">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="input-field" required>
            </div>
            <button type="submit" class="submit-btn">Se connecter</button>
        </form>
        @error('email')
            <div class="alert alert-danger">
                <p class="text-red-500 text-center">{{ $message }}</p>
            </div>
        @enderror

        <div class="mt-4 text-center">
            <p>Vous n'avez pas de compte ? <a href="{{ route('register') }}" class="text-blue-500">Inscrivez-vous
                    ici</a></p>
        </div>

        <!-- Lien vers la page d'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-blue-500">Retour à l'accueil</a>
        </div>
    </div>
</body>

</html>
