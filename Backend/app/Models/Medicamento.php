<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    public $timestamps = false;

    public $table = 'medicamentos';

    protected $primaryKey = 'medicamento_id';

    protected $fillable = [
        'nombre_medicamento',
        'codigo_medicamento',
        'stock',
        'descripcion',
    ];
}
