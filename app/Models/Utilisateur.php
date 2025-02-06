<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';

    public $timestamps = false;

    protected $fillable = [
        'nom',
        'email',
    ];


    protected $primaryKey = 'id_utilisateur';

    // Méthode pour calculer la somme des achats jusqu'à une date donnée
    public function calculerSommeAchatsJusquA($dateX)
    {
        $somme_achats = Transaction::join('type_transaction', 'transactions.id_type_transaction', '=', 'type_transaction.id_type_transaction')
            ->where('transactions.id_utilisateur', $this->id_utilisateur)
            ->where('type_transaction.type', 'achat')
            ->where('transactions.date_transaction', '<=', $dateX)
            ->sum(DB::raw('transactions.quantite * transactions.prix'));

        return $somme_achats;
    }

    // Méthode pour calculer la somme des ventes jusqu'à une date donnée
    public function calculerSommeVentesJusquA($dateX)
    {
        $somme_ventes = Transaction::join('type_transaction', 'transactions.id_type_transaction', '=', 'type_transaction.id_type_transaction')
            ->where('transactions.id_utilisateur', $this->id_utilisateur)
            ->where('type_transaction.type', 'vente')
            ->where('transactions.date_transaction', '<=', $dateX)
            ->sum(DB::raw('transactions.quantite * transactions.prix'));

        return $somme_ventes;
    }

    // Méthode pour calculer la somme des soldes de tous les portefeuilles jusqu'à une date donnée
    public function calculerSoldePortefeuillesJusquA($dateX)
    {
        $portefeuilles = Portefeuille::where('id_utilisateur', $this->id_utilisateur)->pluck('id_portefeuilles');

        if ($portefeuilles->isEmpty()) {
            return 0;
        }

        $totalDepots = Fonds::whereIn('id_portefeuilles', $portefeuilles)
            ->whereHas('typeFonds', function ($query) {
                $query->where('libelle', 'dépôt');
            })
            ->where('daty', '<=', $dateX)
            ->sum(DB::raw('montant_ariary'));

        $totalRetraitsConfirmes = Fonds::whereIn('id_portefeuilles', $portefeuilles)
            ->whereHas('typeFonds', function ($query) {
                $query->where('libelle', 'retrait');
            })
            ->whereHas('statut', function ($query) {
                $query->where('libelle', 'confirmé');
            })
            ->where('daty', '<=', $dateX)
            ->sum(DB::raw('montant_ariary'));

        return $totalDepots - $totalRetraitsConfirmes;
    }

    public static function getTousUtilisateursAchatVenteSolde($dateX)
    {
        $result = DB::table('utilisateur')
            ->leftJoin('transactions', 'utilisateur.id_utilisateur', '=', 'transactions.id_utilisateur')
            ->leftJoin('type_transaction', 'transactions.id_type_transaction', '=', 'type_transaction.id_type_transaction')
            ->select(
                'utilisateur.id_utilisateur',
                'utilisateur.nom',
                DB::raw('SUM(CASE WHEN type_transaction.type = "achat" THEN transactions.quantite * transactions.prix ELSE 0 END) as totalAchat'),
                DB::raw('SUM(CASE WHEN type_transaction.type = "vente" THEN transactions.quantite * transactions.prix ELSE 0 END) as totalVente'),
                DB::raw(
                    '(SELECT 
                        COALESCE(SUM(CASE WHEN tf.libelle = "dépôt" THEN f.montant_ariary ELSE 0 END), 0) 
                        - COALESCE(SUM(CASE WHEN tf.libelle = "retrait" AND s.libelle = "confirmé" THEN f.montant_ariary ELSE 0 END), 0)
                      FROM portefeuille p
                      LEFT JOIN fonds f ON p.id_portefeuilles = f.id_portefeuilles
                      LEFT JOIN type_fonds tf ON f.id_type_fonds = tf.id_type_fonds
                      LEFT JOIN statut s ON f.id_statut = s.id_statut
                      WHERE p.id_utilisateur = utilisateur.id_utilisateur 
                      AND f.daty <= ?) as soldePortefeuille'
                )
            )
            ->groupBy('utilisateur.id_utilisateur', 'utilisateur.nom')
            ->setBindings([$dateX]) 
            ->get();

        return $result;
    }
}
