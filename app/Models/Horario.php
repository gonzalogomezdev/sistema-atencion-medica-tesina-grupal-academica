<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'Horarios';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idHorarios'; 

    protected $fillable = [
        'idHorarios', 'Hora', 'Franja_Horaria'
    ];

    
}