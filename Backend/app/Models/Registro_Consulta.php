<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro_Consulta extends Model
{
    public $timestamps = false;

    public $table = 'registro_consultas';

    protected $primaryKey = 'id_registro_consulta';

    protected $fillable = [
        'numero_seguro_social',
        'fecha_consulta',
        'hora_llego_consultorio',
        'hora_estimada_llegada',
        'hora_atendio',
        'etapa',
        'nivel',
        'urgencia_coloquial',
        'urgencia_medica',
        'paciente_id',
        'medico_paso_id',
        'medico_especialista_id',
        'acompanante',
        'diagnostico',
        'medicamentos',
    ];
}
