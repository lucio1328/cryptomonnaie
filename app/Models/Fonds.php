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
        'id_portefeuilles',
        'id_type_fonds',
        'id_statut',
    ];

    protected $casts = [
        'daty' => 'date',
    ];

    public function portefeuille()
    {
        return $this->belongsTo(Portefeuille::class, 'id_portefeuilles');
    }

    public function typeFonds()
    {
        return $this->belongsTo(TypeFonds::class, 'id_type_fonds');
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class, 'id_statut');
    }
}
