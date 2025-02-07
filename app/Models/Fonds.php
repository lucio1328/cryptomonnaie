<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonds extends Model
{
    use HasFactory;

    protected $table = 'fonds';

    protected $primaryKey = 'id_fonds';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'montant_usd',
        'montant_euro',
        'montant_ariary',
        'daty',
        'id_utilisateur',
        'id_type_fonds',
        'id_statut',
    ];

    protected $casts = [
        'daty' => 'date',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function typeFonds()
    {
        return $this->belongsTo(TypeFonds::class, 'id_type_fonds');
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class, 'id_statut');
    }

    public static function fondTotal($idUtilisateur)
    {
        // Récupérer tous les fonds de cet utilisateur
        $fonds = self::where('id_utilisateur', $idUtilisateur)
            ->where('id_statut', 2)
            ->get();

        $sommeTransaction = Transaction::montantTotal($idUtilisateur);


        if ($fonds) {
            // Calcul du total des dépôts
            $totalDepots = $fonds->where('id_type_fonds', 1)->reduce(function ($carry, $item) {
                return [
                    'usd' => $carry['usd'] + $item->montant_usd,
                    'euro' => $carry['euro'] + $item->montant_euro,
                    'ariary' => $carry['ariary'] + $item->montant_ariary,
                ];
            }, ['usd' => 0, 'euro' => 0, 'ariary' => 0]);

            // Calcul du total des retraits
            $totalRetraits = $fonds->where('id_type_fonds', 2)->reduce(function ($carry, $item) {
                return [
                    'usd' => $carry['usd'] + $item->montant_usd,
                    'euro' => $carry['euro'] + $item->montant_euro,
                    'ariary' => $carry['ariary'] + $item->montant_ariary,
                ];
            }, ['usd' => 0, 'euro' => 0, 'ariary' => 0]);


            // Calcul du solde final
            return [
                'usd' => $totalDepots['usd'] - $totalRetraits['usd'] + $sommeTransaction * Devise::USD,
                'euro' => $totalDepots['euro'] - $totalRetraits['euro'] + $sommeTransaction * Devise::USD,
                'ariary' => $totalDepots['ariary'] - $totalRetraits['ariary'] + $sommeTransaction,
            ];
        } else {
            return [
                'usd' => 0 + $sommeTransaction * Devise::USD,
                'euro' => 0 + $sommeTransaction * Devise::USD,
                'ariary' => 0 + $sommeTransaction,
            ];
        }

    }

}
