<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $response = Http::asForm()->post('http://localhost:8081/api/check-login', [
                'email' => $request->input('email'),
                'motDePasse' => $request->input('password'),
            ]);

            $data = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => $data['message'],
                    'user' => $data['data'],
                ], 200);
            }

            return response()->json([
                'success' => false,
                'error' => $data['error'] ?? 'Identifiants incorrects',
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Une erreur interne est survenue : ' . $e->getMessage(),
            ], 500);
        }
    }



    public function register(Request $request)
    {
        try {
            // Validation des entrées
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|confirmed',
            ]);

            // Appel à l'API Java pour la pré-inscription
            $response = Http::asForm()->post('http://localhost:8081/api/pre-inscription', [
                'nom' => $request->input('name'),
                'email' => $request->input('email'),
                'motDePasse' => $request->input('password'),
                'confirmMotDePasse' => $request->input('password_confirmation'),
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pré-inscription réussie. Vérifiez votre email pour la validation.',
                ], 200);
            }

            return response()->json([
                'success' => false,
                's' => 'Échec de la pré-inscription : ' . $response->body(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Une erreur interne est survenue : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        // Vider la session
        session()->flush();

        // Optionnel : Supprimer le cookie de session
        session()->forget('laravel_session');

        // Rediriger vers la page d'accueil ou une page de connexion
        return redirect('/');
    }



}
