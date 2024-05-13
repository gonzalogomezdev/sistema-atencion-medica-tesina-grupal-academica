<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Paciente;
use App\Models\Usuario;
use App\Mail\EmailConfirmation;
use Illuminate\Support\Str;

// use App\Models\Profesional;

class RegisterController extends Controller
{
	public function showRegisterForm()
    {
        return view('register.register');
    }

	public function register (RegisterRequest $request){
		$data = $request->validated();

        $user = Usuario::create([
            'Email' => $request->input('Email'),
            'Password' => $request->input('Password'),
            'Token' => Str::random(25),
            'Email_verified' => false,
        ]);

        $paciente = Paciente::create([
            'Apellido' => $data['Apellido'] ?? null,
            'Nombre' => $data['Nombre'] ?? null,
            'DNI' => $data['DNI'] ?? null,
            'Telefono' => $data['Telefono'] ?? null,
            'Domicilio' => $data['Domicilio'] ?? null,
            'Fecha_Nacimiento' => $data['Fecha_Nacimiento'] ?? null,
            'Localidades_idLocalidad' => 1,
            'Generos_idGenero' => 1, 
            'Estados_Civiles_idEstado_Civil' => 1, 
            'Roles_idRol' => 1, 
            'Estados_Pacientes_idEstado' => 2,
            'Usuarios_idUsuario' => $user->idUsuario
        ]);

        // $profesional = Profesional::create([
        //     'Apellido' => $data['Apellido'] ?? null,
        //     'Nombre' => $data['Nombre'] ?? null,
        //     'DNI' => $data['DNI'] ?? null,
        //     'Telefono' => $data['Telefono'] ?? null,
        //     'Domicilio' => $data['Domicilio'] ?? null,
        //     'Fecha_Nacimiento' => $data['Fecha_Nacimiento'] ?? null,
        //     'Localidades_idLocalidad' => 1,
        //     'Generos_idGenero' => 1, 
        //     'Estados_Civiles_idEstado_Civil' => 1, 
        //     'Usuarios_idUsuario' => $user->idUsuario
        // ]);
        
        Mail::to($user->Email)->send(new EmailConfirmation($user->Token));
        
		if($user && $paciente) {
            return redirect()->route('register.form')->with('success', 'Se ha registrado con exito');
        } else {
            return redirect()->route('register.form')->with('error', 'Ocurrio un error en el registro');
        }

	}
}