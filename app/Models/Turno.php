<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'Turnos';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idTurno'; 
    
    protected $fillable = [
        'idTurno', 'Fecha', 'Estado_Turno', 'Horarios_idHorarios', 'Pacientes_idPaciente'    
    ];

    // public function horario()
    // {
    //     return $this->belongsTo(Horario::class, 'Horarios_idHorarios');
    // }

    // public function paciente()
    // {
    //     return $this->belongsTo(Paciente::class, 'idPaciente');
    // }
}




