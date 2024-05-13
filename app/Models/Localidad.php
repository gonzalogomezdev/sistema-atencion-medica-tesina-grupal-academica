<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $table = 'Localidades';
    public $timestamps = false; // Deshabilitar las marcas de tiempo
    protected $primaryKey = 'idLocalidad'; 

    protected $fillable = [
        'idLocalidad', 'Desc_Localidad'
    ];

}
