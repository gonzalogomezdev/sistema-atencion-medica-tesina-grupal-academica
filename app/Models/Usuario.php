<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model 
{
    use HasFactory;
    
    protected $table = 'Usuarios';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idUsuario'; 

    protected $fillable = [
        'idUsuario', 'Email', 'Password', 'Token', 'Email_verified'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['Password'] = bcrypt($value);
    }

    public function getPaciente()
    {
        return $this->hasOne(Paciente::class, 'Usuarios_idUsuario', 'idUsuario'); // "Tiene un" y se usa cuando un modelo tiene una relación de uno a uno con otro modelo. 
    }

    public function getProfesional()
    {
        return $this->hasOne(Profesional::class, 'Usuarios_idUsuario', 'idUsuario');
    }

}