<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    public $timestamps = true;

    public $table = 'familias';

    protected $primaryKey = 'id_familia';

    protected $fillable = [
        'nombre_familia',
    ];
}
