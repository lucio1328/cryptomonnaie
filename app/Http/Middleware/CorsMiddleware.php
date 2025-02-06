<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Lire les paramètres de configuration CORS
        $allowedOrigins = Config::get('cors.allowed_origins', []);
        $allowedMethods = Config::get('cors.allowed_methods', []);
        $allowedHeaders = Config::get('cors.allowed_headers', []);
        $exposedHeaders = Config::get('cors.exposed_headers', []);
        $maxAge = Config::get('cors.max_age', 3600);
        $supportsCredentials = Config::get('cors.supports_credentials', false);

        $origin = $request->header('Origin');

        // Vérifier si l'origine est autorisée
        if (in_array('*', $allowedOrigins) || in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }

        // Définir les méthodes HTTP autorisées
        $response->headers->set('Access-Control-Allow-Methods', in_array('*', $allowedMethods)
            ? 'GET, POST, PUT, DELETE, OPTIONS'
            : implode(', ', $allowedMethods)
        );

        // Définir les en-têtes HTTP autorisés
        $response->headers->set('Access-Control-Allow-Headers', in_array('*', $allowedHeaders)
            ? 'Content-Type, X-Requested-With, Authorization'
            : implode(', ', $allowedHeaders)
        );

        // Exposer certains en-têtes
        if (!empty($exposedHeaders)) {
            $response->headers->set('Access-Control-Expose-Headers', implode(', ', $exposedHeaders));
        }

        // Définir la durée de vie du cache des requêtes pré-vol (OPTIONS)
        if ($maxAge) {
            $response->headers->set('Access-Control-Max-Age', $maxAge);
        }

        // Autoriser les credentials (cookies, tokens, sessions)
        if ($supportsCredentials) {
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        }

        // Gérer les requêtes OPTIONS (pré-vol CORS)
        if ($request->isMethod('OPTIONS')) {
            return response()->json(['status' => 'success'], 200, $response->headers->all());
        }

        return $response;
    }
}
