<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- En-tête avec les boutons de connexion et inscription -->
    <header class="bg-blue-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold">Bienvenue sur notre plateforme</h1>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 rounded-lg hover:bg-blue-700">Connexion</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-green-500 rounded-lg hover:bg-green-700">Inscription</a>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <div class="container mx-auto px-4 py-8">
        <div class="text-center">
            <h2 class="text-4xl font-semibold text-gray-800">Découvrez nos fonctionnalités</h2>
            <p class="mt-4 text-lg text-gray-600">Notre plateforme vous offre une expérience enrichissante avec de nombreuses fonctionnalités adaptées à vos besoins.</p>
        </div>

        <!-- Section sur les avantages de la plateforme -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-blue-600">Fonctionnalité 1</h3>
                <p class="mt-4 text-gray-600">Description de la fonctionnalité 1 avec quelques détails pour informer l'utilisateur des avantages.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-blue-600">Fonctionnalité 2</h3>
                <p class="mt-4 text-gray-600">Description de la fonctionnalité 2 avec des informations pratiques et des bénéfices pour l'utilisateur.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-blue-600">Fonctionnalité 3</h3>
                <p class="mt-4 text-gray-600">Explication de la fonctionnalité 3 et de la manière dont elle peut améliorer l'expérience utilisateur.</p>
            </div>
        </div>

        <!-- Section pour les témoignages utilisateurs -->
        <div class="mt-16 text-center">
            <h3 class="text-3xl font-semibold text-gray-800">Ce que disent nos utilisateurs</h3>
            <p class="mt-4 text-lg text-gray-600">Découvrez les retours d'expérience de nos utilisateurs satisfaits.</p>
            <div class="mt-8 flex justify-center space-x-4">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs">
                    <p class="italic text-gray-500">"Cette plateforme a révolutionné mon travail. Très simple à utiliser!"</p>
                    <p class="mt-4 font-bold text-gray-700">Jean Dupont</p>
                    <p class="text-gray-500">Client satisfait</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs">
                    <p class="italic text-gray-500">"J'ai trouvé tout ce dont j'avais besoin ici, et le support est au top!"</p>
                    <p class="mt-4 font-bold text-gray-700">Marie Martin</p>
                    <p class="text-gray-500">Utilisatrice enthousiaste</p>
                </div>
            </div>
        </div>

        <!-- Section d'appel à l'action -->
        <div class="mt-16 text-center">
            <h3 class="text-3xl font-semibold text-gray-800">Rejoignez-nous dès aujourd'hui!</h3>
            <p class="mt-4 text-lg text-gray-600">Inscrivez-vous maintenant pour profiter de toutes nos fonctionnalités exceptionnelles.</p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-700">Commencer maintenant</a>
            </div>
        </div>
    </div>

</body>
</html>
