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
}

