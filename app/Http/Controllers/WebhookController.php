<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function userValidated(Request $request)
    {
        try {

            // Validation manuelle
            $validatedData = $request->validate([
                'email' => 'required|email',
                'name' => 'required',
            ]);

            // Vérifier si l'utilisateur existe déjà
            $user = Utilisateur::where('email', $validatedData['email'])->first();

            if (!$user) {
                try {
                    // Créer l'utilisateur dans la base de P2
                    $user = Utilisateur::create([
                        'nom' => $validatedData['name'],
                        'email' => $validatedData['email'],
                    ]);
                } catch (\Exception $e) {
                    // Gestion d'erreur si la création échoue
                    return response()->json([
                        'error' => 'Erreur lors de la création de l’utilisateur.',
                        'message' => $e->getMessage(),
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'L’utilisateur existe déjà dans P2.',
                ], 200);
            }

            return response()->json([
                'message' => 'Utilisateur enregistré avec succès dans P2.',
                'user' => $user,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation des données échouée.',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur inattendue est survenue.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
