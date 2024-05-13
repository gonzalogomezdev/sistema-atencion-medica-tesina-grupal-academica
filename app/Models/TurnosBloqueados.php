<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnosBloqueados extends Model
{
    use HasFactory;

    protected $table = 'turnos_bloqueados';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idTurnoBloqueado'; 
    
    protected $fillable = [
        'idTurnoBloqueado', 'Fecha'  
    ];
}
