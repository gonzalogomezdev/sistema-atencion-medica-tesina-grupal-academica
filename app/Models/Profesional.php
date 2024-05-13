<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    use HasFactory;

    protected $table = 'Profesional';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idProfesional'; 

    protected $fillable = [
        'idProfesional', 'Nombre', 'Apellido', 'DNI', 'Telefono', 'Fecha_Nacimiento', 'Domicilio', 'Localidades_idLocalidad', 'Generos_idGenero', 'Estados_Civiles_idEstado_Civil', 'Usuarios_idUsuario'
    ];

    public function getUsuario()
    {
        return $this->belongsTo(Usuario::class, 'Usuarios_idUsuario', 'idUsuario'); // "Pertenece a" y se utiliza cuando un modelo pertenece a otro modelo. 
    }
}
