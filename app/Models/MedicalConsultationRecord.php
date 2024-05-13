<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalConsultationRecord extends Model
{
    use HasFactory;

    protected $table = 'Historiales_Clinicos';
    public $timestamps = false;
    protected $primaryKey = 'idHistorial';

    protected $fillable = [
        'idHistorial', 'Diagnostico', 'Tratamiento', 'Medicamento', 'Pacientes_idPaciente', 'Estados_Historiales_idEstado_Historial'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'Usuarios_idUsuario');
    }
    
}
