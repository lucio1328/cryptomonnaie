<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    use HasFactory;

    protected $table = 'cryptos';
    protected $primaryKey = 'id_cryptos';
    public $timestamps = false;

    protected $fillable = [
        'nom_crypto',
        'symbole',
        'pourcentage',
        'prix_actuel',
    ];

    protected $casts = [
        'pourcentage' => 'decimal:2',
        'prix_actuel' => 'decimal:2',
    ];
}
