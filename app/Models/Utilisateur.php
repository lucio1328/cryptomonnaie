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
    ];


    protected $primaryKey = 'id_utilisateur';
}
