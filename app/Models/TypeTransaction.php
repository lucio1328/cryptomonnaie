<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTransaction extends Model
{
    use HasFactory;

    protected $table = 'type_transaction';
    protected $primaryKey = 'id_type_transaction';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['type'];
}
