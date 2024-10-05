<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peticion extends Model
{
    public $timestamps = true;

    public $table = 'peticiones_oracion';

    protected $primaryKey = 'id_peticion_oracion';

    protected $fillable = [
        'nombre_completo',
        'telefono',
        'descripcion_peticion',
        'fecha_peticion',
        'listo',
        'id_ministerio',
    ];
}
