<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermisosRoles extends Model
{
    public $timestamps = true;

    public $table = 'permisos_roles';

    protected $primaryKey = 'id_permiso_rol';

    protected $fillable = [
        'id_rol',
        'id_permiso',
    ];
}
