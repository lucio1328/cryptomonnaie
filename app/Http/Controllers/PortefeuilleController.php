<?php

namespace App\Http\Controllers;

use App\Mail\FondsConfirmationMail;
use App\Models\Portefeuille;
use App\Models\Crypto;
use App\Models\Fonds;
use App\Models\TypeFonds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function storeFonds(Request $request, $id)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0',
            'daty' => 'required|date',
            'type_operation' => 'required|exists:type_fonds,id_type_fonds',
        ]);

        $exchangeRateUsd = 0.00024;
        $exchangeRateEuro = 0.00022;

        $montant_usd = $request->montant * $exchangeRateUsd;
        $montant_euro = $request->montant * $exchangeRateEuro;

        $portefeuille = Portefeuille::findOrFail($id);

        $fonds = Fonds::create([
            'montant_usd' => $montant_usd,
            'montant_euro' => $montant_euro,
            'montant_ariary' => $request->montant,
            'daty' => $request->daty,
            'id_portefeuilles' => $id,
            'id_type_fonds' => $request->type_operation,
            'id_statut' => 1,
        ]);

        $user = $portefeuille->utilisateur;
        Mail::to($user->email)->send(new FondsConfirmationMail($user, $fonds));

        return redirect()->route('portefeuilles.fonds', $id)
                     ->with('success', 'En attente de votre validation par email');
    }

    public function gererFonds($id)
    {
        $portefeuille = Portefeuille::findOrFail($id);
        $typeFonds = TypeFonds::all();

        return view('portefeuilles.gerer', compact('portefeuille', 'typeFonds'));
    }

    public function show($id)
    {
        $portefeuille = Portefeuille::findOrFail($id);

        return view('portefeuilles.show', compact('portefeuille'));
    }

    public function create()
    {
        $cryptos = Crypto::all();

        return view('portefeuilles.create', compact('cryptos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_portefeuille' => 'required|string|max:50',
            'solde' => 'required|numeric',
            'Id_utilisateur' => 'required|exists:utilisateur,id_utilisateur',
            'Id_cryptos' => 'required|exists:cryptos,id_cryptos',
        ]);

        Portefeuille::create([
            'nom_portefeuille' => $request->nom_portefeuille,
            'solde' => $request->solde,
            'date_creation' => now(),
            'id_utilisateur' => $request->Id_utilisateur,
            'id_cryptos' => $request->Id_cryptos,
        ]);

        return redirect()->route('portefeuilles.liste')->with('success', 'Portefeuille ajouté avec succès.');
    }

    public function index()
    {
        $portefeuilles = Portefeuille::all();
        return view('portefeuilles.index', compact('portefeuilles'));
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

