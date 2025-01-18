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
}
