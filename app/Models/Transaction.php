<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'id_transactions';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'quantite',
        'prix',
        'date_transaction',
        'id_utilisateur',
        'id_cryptos',
        'id_type_transaction',
    ];

    protected $casts = [
        'date_transaction' => 'datetime',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function cryptos()
    {
        return $this->belongsTo(Crypto::class, 'id_cryptos');
    }

    public function type_transaction()
    {
        return $this->belongsTo(TypeTransaction::class, 'id_type_transaction');
    }

    public static function montantTotal($idUtilisateur)
    {
        // Récupérer toutes les transactions de l'utilisateur
        $transactions = self::where('id_utilisateur', $idUtilisateur)->get();

        // Calcul du total des achats
        $totalAchats = $transactions->where('id_type_transaction', 2)->reduce(function ($carry, $item) {
            return $carry + ($item->quantite * $item->prix);
        }, 0);

        // Calcul du total des ventes
        $totalVentes = $transactions->where('id_type_transaction', 1)->reduce(function ($carry, $item) {
            return $carry + ($item->quantite * $item->prix);
        }, 0);

        // Calcul du solde final (montant possédé)
        return $totalVentes - $totalAchats;
    }

}
