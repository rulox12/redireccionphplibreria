<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaccion extends Model
{
    protected $fillable = [
        'referencia',
        'descripcion',
        'requestid',
        'expiracion',
        'userId',
        'total'
    ];
}
