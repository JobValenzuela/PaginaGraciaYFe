<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngresosEgresos extends Model
{
    public $timestamps = true;

    public $table = 'ingresos_egresos';

    protected $primaryKey = 'id_ingreso_egreso';

    protected $fillable = [
        'tipo',
        'concepto',
        'cantidad',
        'descripcion',
        'fecha',
        'id_usuario',
    ];
}
