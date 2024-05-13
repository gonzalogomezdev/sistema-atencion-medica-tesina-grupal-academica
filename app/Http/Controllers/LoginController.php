<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\Usuario;
use App\Models\Paciente;
use App\Models\Profesional;

use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('Email');
    	$password = $request->input('Password');

    	$user = Usuario::where('Email', $email)->first();

        // if ($user->Email_verified == 1) {
            if ($user && (password_verify($password, $user->Password) || $password === $user->Password)) {

                $patient = Paciente::where('Usuarios_idUsuario', $user->idUsuario)->first();
    
                $professional = Profesional::where('Usuarios_idUsuario', $user->idUsuario)->first();
    
                if ($professional) {
                    //Se crea la session del usuario. Primero se pone una clave, y en ella se almacena un valor
                    Session::put('UsuarioId', $user->idUsuario);
                    Session::put('Profesional_'. $user->idUsuario, $professional);
                    return redirect()->route('dashboardDoctor');
                } elseif ($patient) {
                    if ($patient->Roles_idRol === 1) {
                        return redirect()->route('login.form')->with('inProgress', 'Su solicitud esta siendo procesada');
                    } elseif ($patient->Roles_idRol === 2) {
                        Session::put('UsuarioId', $user->idUsuario);
                        Session::put('Paciente_'. $user->idUsuario, $patient);
                        return redirect()->route('dashboardPatient');
                    } 
                } else {
                    return redirect()->route('login.form')->with('errorUser', 'El usuario no tiene un paciente asociado.');
                }
            } else {
                return redirect()->route('login.form')->with('errorData', 'Acceso inválido. Por favor, inténtelo otra vez.');
            }
        // } else {
        //     return redirect()->route('login.form')->with('errorVerified', 'Acceso inválido. Debes confirmar tu email.');
        // }

        
    }
}

?>
