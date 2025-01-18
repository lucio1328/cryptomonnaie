<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueCours extends Model
{
    use HasFactory;

    protected $table = 'historique_cours';

    protected $primaryKey = 'id_historique_cours';

    public $timestamps = false;

    protected $fillable = [
        'cours',
        'date_enregistrement',
        'id_cryptos'
    ];

    public function crypto()
    {
        return $this->belongsTo(Crypto::class, 'id_cryptos');
    }
}
