<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';

    public $timestamps = false;

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe'
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $primaryKey = 'id_utilisateur';
}
