<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provincia;
use App\Models\Localidad;

class Prov_LocaController extends Controller
{
    public function showProv()
    {
        $provincias = Provincia::all();
        return ['provincia' => $provincias];
    }

    public function getLocalidad(Request $request) 
    {
        $provincia = $request->input('provincia');

        $result = Localidad::select('idLocalidad', 'Desc_Localidad', 'Provincias_idProvincia')
        ->where('Provincias_idProvincia', $provincia)
        ->orderBy('Desc_Localidad')
        ->get();

        return response()->json($result);
    }
}