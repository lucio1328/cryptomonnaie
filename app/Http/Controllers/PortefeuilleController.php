<?php

namespace App\Http\Controllers;

use App\Mail\FondsConfirmationMail;
use App\Models\Portefeuille;
use App\Models\Crypto;
use App\Models\Fonds;
use App\Models\TypeFonds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PortefeuilleController extends Controller
{

    public function confirmFonds($id)
    {
        $fonds = Fonds::findOrFail($id);

        if (!$fonds->montant_ariary) {
            return redirect()->back()->with('error', 'Aucun montant en Ariary trouvé pour cette opération.');
        }

        $portefeuille = Portefeuille::findOrFail($fonds->id_portefeuilles);

        if (!$portefeuille) {
            return redirect()->back()->with('error', 'Portefeuille associé introuvable.');
        }

        if ($fonds->id_statut == 2) {
            return redirect()->back()->with('error', 'L\'opération a déjà été validée.');
        }

        $portefeuille->solde += $fonds->montant_ariary;

        $portefeuille->save();

        $fonds->id_statut = 2;
        $fonds->save();

        return redirect()->route('portefeuilles.fonds', $portefeuille->id_portefeuilles)
            ->with('success', 'Opération de fonds validée et solde mis à jour avec succès.');
    }

    public function storeFonds(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'montant' => 'required|numeric|min:0',
                'daty' => 'required|date',
                'type_operation' => 'required|exists:type_fonds,id_type_fonds',
            ]);

            // Taux de change
            $exchangeRateUsd = 0.00024;
            $exchangeRateEuro = 0.00022;


            // Conversion des montants
            $montant_usd = $validatedData['montant'] * $exchangeRateUsd;
            $montant_euro = $validatedData['montant'] * $exchangeRateEuro;

            // recuperer l'utilisateur
            $user = session('user');

            if ($validatedData['type_operation'] == 2) {
                $fondTotal = Fonds::fondTotal($user->id_utilisateur);
                if ($validatedData['montant'] > $fondTotal['ariary']) {
                    return response()->json([
                        'message' => 'Votre solde est insuffisant',
                        "success" => false
                    ]);
                }
            }

            // Création du fonds
            $fonds = Fonds::create([
                'montant_usd' => $montant_usd,
                'montant_euro' => $montant_euro,
                'montant_ariary' => $validatedData['montant'],
                'daty' => $validatedData['daty'],
                'id_utilisateur' => $user->id_utilisateur,
                'id_type_fonds' => $validatedData['type_operation'],
                'id_statut' => 1, // En attente de validation
            ]);


            // Réponse JSON (201 Created)
            return response()->json([
                'message' => 'Succes, en attente de validation',
                'fonds' => $fonds,
                "success" => true
            ], 201);

        } catch (ValidationException $e) {
            // Erreurs de validation (422 Unprocessable Entity)
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Autres erreurs (500 Internal Server Error)
            return response()->json([
                'error' => 'Une erreur est survenue ' + $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function gererFonds($id)
    {
        $portefeuille = Portefeuille::findOrFail($id);
        $typeFonds = TypeFonds::all();

        return view('portefeuilles.gerer', compact('portefeuille', 'typeFonds'));
    }

    public function show($id)
    {
        // Chercher le portefeuille avec l'ID
        $portefeuille = Portefeuille::with(['crypto', 'utilisateur'])->findOrFail($id);

        // Retourner une réponse JSON avec les données du portefeuille
        return response()->json($portefeuille);
    }

    public function getByUtilisateur($id)
    {
        try {
            $portefeuilles = Portefeuille::getByUtilisateurr($id);

            if ($portefeuilles->isEmpty()) {
                return response()->json([
                    'message' => 'Aucun portefeuille trouvé.'
                ], 404);
            }

            return response()->json([
                'message' => 'Liste des portefeuilles récupérée avec succès.',
                'portefeuilles' => $portefeuilles
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des portefeuilles.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $cryptos = Crypto::all();

        return view('portefeuilles.create', compact('cryptos'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom_portefeuille' => 'required|string|max:50',
                'solde' => 'required|numeric',
                'Id_utilisateur' => 'required|exists:utilisateur,id_utilisateur',
                'Id_cryptos' => 'required|exists:cryptos,id_cryptos',
            ]);

            $portefeuille = Portefeuille::create([
                'nom_portefeuille' => $validatedData['nom_portefeuille'],
                'solde' => $validatedData['solde'],
                'date_creation' => now(),
                'id_utilisateur' => $validatedData['Id_utilisateur'],
                'id_cryptos' => $validatedData['Id_cryptos'],
            ]);

            return response()->json([
                'message' => 'Portefeuille ajouté avec succès.',
                'portefeuille' => $portefeuille
            ], 201); // Code de statut HTTP 201 (Création réussie)

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation.',
                'errors' => $e->errors()
            ], 400); // 400 Bad Request

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Erreur lors de l’enregistrement du portefeuille.',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur inattendue est survenue.',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }


    public function index()
    {
        try {
            $portefeuilles = Portefeuille::all();

            // Vérifier s'il y a des portefeuilles
            if ($portefeuilles->isEmpty()) {
                return response()->json([
                    'message' => 'Aucun portefeuille trouvé.'
                ], 404); // Code 404 : Ressource non trouvée
            }

            return response()->json([
                'message' => 'Liste des portefeuilles récupérée avec succès.',
                'portefeuilles' => $portefeuilles
            ], 200); // Code 200 : Succès

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des portefeuilles.',
                'details' => $e->getMessage()
            ], 500); // Code 500 : Erreur serveur
        }
    }


    public function edit($id)
    {
        $portefeuille = Portefeuille::findOrFail($id);
        $cryptos = Crypto::all();
        return view('portefeuilles.edit', compact('portefeuille', 'cryptos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_portefeuille' => 'required|string|max:50',
            'solde' => 'required|numeric',
            'Id_utilisateur' => 'required|exists:utilisateur,Id_utilisateur',
            'Id_cryptos' => 'required|exists:cryptos,Id_cryptos',
        ]);

        $portefeuille = Portefeuille::findOrFail($id);

        $portefeuille->update([
            'nom_portefeuille' => $request->nom_portefeuille,
            'solde' => $request->solde,
            'Id_utilisateur' => $request->Id_utilisateur,
            'Id_cryptos' => $request->Id_cryptos,
        ]);

        return redirect()->route('portefeuilles.index')->with('success', 'Portefeuille mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $portefeuille = Portefeuille::findOrFail($id);
        $portefeuille->delete();

        return redirect()->route('portefeuilles.index')->with('success', 'Portefeuille supprimé avec succès.');
    }
}

