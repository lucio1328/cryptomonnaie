<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function calculerCommission()
    {
        $commission = Commission::where('Id_cryptos', $this->id_cryptos)
            ->where('Id_type_transaction', $this->id_type_transaction)
            ->where('daty', '<=', $this->date_transaction)
            ->orderBy('daty', 'desc')
            ->first();

        if (!$commission) {
            return 0;
        }

        $montant_commission = ($this->quantite * $this->prix) * ($commission->pourcentage / 100);

        return $montant_commission;
    }

    public function calculerSommeCommissions($Id_cryptos = null, $dateDebut, $dateFin)
    {
        $query = Transaction::join('commission', function ($join) {
            $join->on('transactions.id_cryptos', '=', 'commission.id_cryptos')
                ->on('transactions.id_type_transaction', '=', 'commission.id_type_transaction');
        })
            ->whereBetween('transactions.date_transaction', [$dateDebut, $dateFin]);

        if ($Id_cryptos) {
            $query->where('transactions.id_cryptos', $Id_cryptos);
        }

        $somme_commissions = $query->sum(DB::raw('transactions.quantite * transactions.prix * (commission.pourcentage / 100)'));

        return $somme_commissions;
    }

    public function calculerMoyenneCommissions($Id_cryptos = null, $dateDebut, $dateFin)
    {
        $query = Transaction::join('commission', function ($join) {
            $join->on('transactions.id_cryptos', '=', 'commission.Id_cryptos')
                ->on('transactions.id_type_transaction', '=', 'commission.Id_type_transaction');
        })
            ->whereBetween('transactions.date_transaction', [$dateDebut, $dateFin]);

        if ($Id_cryptos) {
            $query->where('transactions.id_cryptos', $Id_cryptos);
        }

        $moyenne_commissions = $query->avg(DB::raw('transactions.quantite * transactions.prix * (commission.pourcentage / 100)'));

        return $moyenne_commissions;
    }

    public function getTousUtilisateursAchatVente()
    {
        $result = DB::table('utilisateur')
            ->leftJoin('transactions', 'utilisateur.id_utilisateur', '=', 'transactions.id_utilisateur')
            ->leftJoin('type_transaction', 'transactions.id_type_transaction', '=', 'type_transaction.id_type_transaction')
            ->select(
                'utilisateur.id_utilisateur',
                'utilisateur.nom',
                DB::raw('SUM(CASE WHEN type_transaction.type = "achat" THEN transactions.quantite * transactions.prix ELSE 0 END) as totalAchat'),
                DB::raw('SUM(CASE WHEN type_transaction.type = "vente" THEN transactions.quantite * transactions.prix ELSE 0 END) as totalVente')
            )
            ->groupBy('utilisateur.id_utilisateur', 'utilisateur.nom')
            ->get();

        return $result;
    }
}
