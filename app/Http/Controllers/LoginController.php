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

            // Appel à l'API Java pour vérifier les identifiants
            $response = Http::asForm()->post(env('SPRING_BOOT_URL') . '/api/check-login', [
                'email' => $request->input('email'),
                'motDePasse' => $request->input('password'),
            ]);

            // Si la réponse est réussie
            if ($response->successful()) {

                $data = $response->json();

                // Extraire les informations utilisateurreturn redirect()->route('confirmPin')->with('success', $message);
                $utilisateur = $data['data'];
                $message = $data['message'];

                // Stocker les données utilisateur dans la session Laravel
                session([
                    'utilisateur_id' => $utilisateur['idUtilisateur'],
                    'utilisateur_nom' => $utilisateur['nom'],
                    'utilisateur_email' => $utilisateur['email'],
                ]);


                // Rediriger vers le tableau de bord avec un message de succès
                return redirect()->route('confirmPin')->with('success', $message);
                // return redirect()->intended('/dashboard')->with('success', $message);
            }

            // Si une erreur est renvoyée par l'API
            return back()->withErrors([
                'email' => $response->json('error', 'Une erreur est survenue lors de l\'authentification.'),
            ]);
            dd($response->status(), $response->json());


        } catch (\Exception $e) {
            // En cas d'erreur de connexion ou d'exception
            echo($e->getMessage());
            
        }
    }


    public function register(Request $request)
    {

        $response = Http::asForm()->post(env('SPRING_BOOT_URL') . '/api/pre-inscription', [
            'nom' => $request->input('name'),
            'email' => $request->input('email'),
            'motDePasse' => $request->input('password'),
            'confirmMotDePasse' => $request->input('password_confirmation'),
        ]);

        if ($response->successful()) {
            return redirect()
                ->route('register')
                ->with('success', 'Pré-inscription réussie. Vérifiez votre email pour la validation.');
        }

        return redirect()
            ->route('register')
            ->with('error', 'Échec de la pré-inscription : ' . $response->body());
    }



}
