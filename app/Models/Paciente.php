<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model 
{
    use HasFactory;

    protected $table = 'Pacientes';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idPaciente'; 

    protected $fillable = [
        'idPaciente', 'Nombre', 'Apellido', 'DNI', 'Telefono', 'Fecha_Nacimiento', 'Domicilio', 'Localidades_idLocalidad', 'Generos_idGenero', 'Estados_Civiles_idEstado_Civil', 'Roles_idRol', 'Estados_Pacientes_idEstado', 'Usuarios_idUsuario'
    ];

    public function getUsuario()
    {
        return $this->belongsTo(Usuario::class, 'Usuarios_idUsuario', 'idUsuario'); // "Pertenece a" y se utiliza cuando un modelo pertenece a otro modelo. 
    }

    public function medicalHistory()
    {
        return $this->hasMany(MedicalHistory::class, 'Pacientes_idPaciente');
    }
}
