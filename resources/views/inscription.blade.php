<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('css/connection.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Créer un compte</h1>
        <p class="text-center text-gray-600 mb-6">Inscrivez-vous pour commencer à utiliser nos services.</p>

        @if(session('success'))
            <div class="alert alert-success">
                <p class="text-green-500 text-center">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <p class="text-red-500 text-center">{{ session('error') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name">Nom completggdf</label>
                <input type="text" name="name" id="name" class="input-field" required>
            </div>
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="input-field" required>
            </div>
            <div class="mb-4">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="input-field" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" required>
            </div>

            <button type="submit" class="submit-btn">S'inscrire</button>
        </form>

        <div class="mt-4 text-center">
            <p>Vous avez déjà un compte ? <a href="{{ route('login') }}" class="text-blue-500">Connectez-vous ici</a></p>
        </div>

        <!-- Lien vers la page d'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-blue-500">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>
