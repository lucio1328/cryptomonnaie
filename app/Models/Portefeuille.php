<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portefeuille extends Model
{
    use HasFactory;

    protected $table = 'portefeuilles';
    protected $primaryKey = 'id_portefeuilles';
    protected $fillable = [
        'nom_portefeuille',
        'solde',
        'date_creation',
        'id_utilisateur',
        'id_cryptos',
    ];
    protected $casts = [
        'date_creation' => 'datetime',
    ];

    public $timestamps = false;

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function crypto()
    {
        return $this->belongsTo(Crypto::class, 'id_cryptos');
    }

    public static function getByUtilisateurr($id_utilisateur)
    {
        return Portefeuille::where('id_utilisateur', $id_utilisateur)->get();
    }

    public function getSoldeUtilisateurParDate($idUtilisateur, $date)
    {
        $solde = Fonds::whereHas('portefeuille', function ($query) use ($idUtilisateur) {
            $query->where('id_utilisateur', $idUtilisateur);
        })
            ->where('daty', '<=', $date)
            ->selectRaw('SUM(montant_usd) as total_usd, SUM(montant_euro) as total_euro, SUM(montant_ariary) as total_ariary')
            ->first();

        return [
            'solde_usd' => $solde->total_usd ?? 0,
            'solde_euro' => $solde->total_euro ?? 0,
            'solde_ariary' => $solde->total_ariary ?? 0,
        ];
    }
}
