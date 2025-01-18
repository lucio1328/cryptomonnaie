<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFonds extends Model
{
    use HasFactory;

    protected $table = 'type_fonds';
    protected $primaryKey = 'id_type_fonds';

    protected $fillable = [
        'type',
    ];
    public $timestamps = false;
}
