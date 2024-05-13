<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoHistoriales extends Model
{
    use HasFactory;

    protected $table = "Estados_Historiales";
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idEstado_Historial'; 

    protected $fillable = [
        'idEstado_Historial', 'Desc_Historial'
    ];

    // Se deberia agregar el registro de las veces que se cambia el estado y la fecha.


}
