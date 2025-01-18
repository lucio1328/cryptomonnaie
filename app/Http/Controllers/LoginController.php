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
        $credentials = $request->only('email', 'mot_de_passe');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification ne correspondent pas.',
        ]);
    }

    public function register(Request $request)
    {
        // Validation des entrées
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'motDePasse' => 'required|string|min:6',
            'confirmMotDePasse' => 'required|string|min:6|same:motDePasse',
        ]);

        // Appel à l'API Java
        $response = Http::get('http://localhost:8080/api/pre-inscription', [
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'motDePasse' => $validated['motDePasse'],
            'confirmMotDePasse' => $validated['confirmMotDePasse'],
        ]);

        // Vérification de la réponse
        if ($response->successful()) {
            return redirect()
                ->route('register')
                ->with('success', 'Pré-inscription réussie. Vérifiez votre email pour la validation.');
        }

        // En cas d'erreur
        return redirect()
            ->route('register')
            ->with('error', 'Échec de la pré-inscription : ' . $response->body());
    }
}
