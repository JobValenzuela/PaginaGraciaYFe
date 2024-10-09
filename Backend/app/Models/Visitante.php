<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    public $timestamps = true;

    public $table = 'visitantes';

    protected $primaryKey = 'id_visitante';

    protected $fillable = [
        'nombre',
        'telefono',
        'fecha_visita',
        'id_ministerio',
    ];
}
