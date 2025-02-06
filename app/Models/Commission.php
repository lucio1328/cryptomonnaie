<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model {
    use HasFactory;

    protected $table = 'commission'; 
    protected $primaryKey = 'id_commission'; 
    public $timestamps = false; 

    protected $fillable = ['id_cryptos', 'id_type_transaction', 'pourcentage', 'daty'];

    // Relations
    public function crypto() {
        return $this->belongsTo(Crypto::class, 'id_cryptos');
    }

    public function typeTransaction() {
        return $this->belongsTo(Transaction::class, 'id_type_transaction');
    }
}
