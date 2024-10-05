<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobiliario extends Model
{
    public $timestamps = true;

    public $table = 'mobiliario';

    protected $primaryKey = 'id_mobiliario';

    protected $fillable = [
        'nombre',
        'cantidad',
        'descripcion',
        'id_miembro_encargado',
    ];
}
