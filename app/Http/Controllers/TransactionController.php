<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Portefeuille;
use App\Models\Transaction;
use App\Models\TypeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quantite' => 'required|integer|min:1',
            'date_transaction' => 'required|date',
            'id_cryptos' => 'required|exists:cryptos,id_cryptos',
            'id_type_transaction' => 'required|exists:type_transaction,id_type_transaction',
            'id_utilisateur' => 'required|exists:utilisateur,id_utilisateur',
        ]);
        $cryptos = Crypto::findOrFail($validated['id_cryptos']);
        $portefeuille = Portefeuille::where('id_cryptos', $validated['id_cryptos'])
                ->where('id_utilisateur', $validated['id_utilisateur'])
                ->first();

        if ($validated['id_type_transaction'] == 1) { //vente
            if (!$portefeuille) {
                return redirect()->back()->withErrors(['portefeuille' => 'Aucun portefeuille trouvé pour cet utilisateur et cette cryptomonnaie.']);
            }

            if ($portefeuille->solde < $validated['quantite']) {
                return redirect()->back()->withErrors(['solde' => 'Solde insuffisant dans le portefeuille.']);
            }

            $portefeuille->solde -= $validated['quantite'];

            $portefeuille->save();
        }
        else { //achat
            if($portefeuille->valeur < $validated['quantite'] * $cryptos->prix_actuel) {
                return redirect()->back()->withErrors(['valeur' => 'Valeur insuffisante dans le portefeuille.']);
            }

            $portefeuille->solde += $validated['quantite'];

            $portefeuille->save();
        }

        $transaction = new Transaction();
        $transaction->quantite = $validated['quantite'];
        $transaction->prix = $validated['quantite'] * $cryptos->prix_actuel;
        $transaction->date_transaction = $validated['date_transaction'];
        $transaction->id_cryptos = $validated['id_cryptos'];
        $transaction->id_type_transaction = $validated['id_type_transaction'];
        $transaction->id_utilisateur = $validated['id_utilisateur'];
        $transaction->save();

        return redirect()->route('transactions.form')->with('success', 'Transaction créée avec succès');
    }

    public function create()
    {
        $cryptos = Crypto::all();
        $typeTransactions = TypeTransaction::all();

        return view('transactions.create', compact('typeTransactions','cryptos'));
    }

    public function vente($idUtilisateur)
    {
        $ventes = Transaction::where('id_utilisateur', $idUtilisateur)
            ->where('id_type_transaction', 1)
            ->get();

        return view('transactions.vente', compact('ventes'));
    }

    public function achat($idUtilisateur)
    {
        $achats = Transaction::where('id_utilisateur', $idUtilisateur)
            ->where('id_type_transaction', 2)
            ->get();

        return view('transactions.achat', compact('achats'));
    }

    public function historique() {
        $transactions = Transaction::all();

        return view('transactions.historique', compact('transactions'));
    }
}
