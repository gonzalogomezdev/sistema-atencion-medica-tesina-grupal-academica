<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'Historiales_Clinicos';
    public $timestamps = false;
    protected $primaryKey = 'idHistorial';
    
    protected $fillable = [
        'idHistorial', 'Diagnostico', 'Tratamiento', 'Medicamento', 'Fecha', 'Pacientes_idPaciente', 'Estados_Historiales_idEstado_Historial'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'idPaciente');
    }

    public function estadoshistoriales()
    {
        return $this->belongsTo(Paciente::class, 'Estados_Historiales_idEstado_Historial');
    }

}
