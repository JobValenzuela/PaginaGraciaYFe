<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    public $timestamps = true;

    public $table = 'permisos';

    protected $primaryKey = 'id_permiso';

    protected $fillable = [
        'clave_permiso',
        'nombre_publico',
    ];
}
