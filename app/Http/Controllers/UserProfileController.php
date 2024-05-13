<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Profesional;
use App\Models\Usuario;
use App\Models\Provincia;
use Carbon\Carbon;

class UserProfileController extends Controller
{
    private $provLocaController;

    public function __construct(Prov_LocaController $provLocaController) {
        $this->provLocaController = $provLocaController;
    }

    public function showUserProfile()
    {
        $idUser = Session('UsuarioId');

        $professional = Session('Profesional_' . $idUser);
        $patient = Session('Paciente_' . $idUser);

        $provincias = $this->provLocaController->showProv();

        if ($professional || $patient) {
            $infoPatient = Paciente::where('Usuarios_idUsuario', $idUser)
            ->rightJoin('Localidades', 'Pacientes.Localidades_idLocalidad', '=', 'Localidades.idLocalidad')
            ->join('Provincias', 'Localidades.Provincias_idProvincia', '=', 'Provincias.idProvincia')
            ->leftjoin('Generos', 'Pacientes.Generos_idGenero', '=', 'Generos.idGenero')
            ->join('Estados_Civiles', 'Pacientes.Estados_Civiles_idEstado_Civil', '=', 'Estados_Civiles.idEstado_Civil')
            ->join('Usuarios', 'Pacientes.Usuarios_idUsuario', '=', 'Usuarios.idUsuario')
            ->select('Usuarios.Email', 'Pacientes.Nombre', 'Pacientes.Apellido', 'Pacientes.DNI', 'Pacientes.Telefono', 'Pacientes.Fecha_Nacimiento', 'Pacientes.Domicilio', 'Localidades.Desc_Localidad', 'Generos.Desc_Genero', 'Estados_Civiles.Desc_Estado', 'Provincias.Desc_Prov')
            ->first();

            $infoProfessional = Profesional::where('Usuarios_idUsuario', $idUser)
            ->rightJoin('Localidades', 'Profesional.Localidades_idLocalidad', '=', 'Localidades.idLocalidad')
            ->join('Provincias', 'Localidades.Provincias_idProvincia', '=', 'Provincias.idProvincia')
            ->leftjoin('Generos', 'Profesional.Generos_idGenero', '=', 'Generos.idGenero')
            ->join('Estados_Civiles', 'Profesional.Estados_Civiles_idEstado_Civil', '=', 'Estados_Civiles.idEstado_Civil')
            ->join('Usuarios', 'Profesional.Usuarios_idUsuario', '=', 'Usuarios.idUsuario')
            ->select('Usuarios.Email', 'Profesional.Nombre', 'Profesional.Apellido', 'Profesional.DNI', 'Profesional.Telefono', 'Profesional.Fecha_Nacimiento', 'Profesional.Domicilio', 'Localidades.Desc_Localidad', 'Generos.Desc_Genero', 'Estados_Civiles.Desc_Estado', 'Provincias.Desc_Prov')
            ->first();

            $usuario = $infoProfessional ?? $infoPatient;

            $usuario->Desc_Localidad = $infoPatient ? $infoPatient->Desc_Localidad : null;
            $usuario->Desc_Genero = $infoPatient ? $infoPatient->Desc_Genero : null;
            $usuario->Desc_Estado = $infoPatient ? $infoPatient->Desc_Estado : null;

            $fechaNacimiento = Carbon::parse($infoPatient ? $infoPatient->Fecha_Nacimiento : $infoProfessional->Fecha_Nacimiento);
            $usuario->Edad = $fechaNacimiento->diffInYears(Carbon::now());

            return view('dashboard.perfil.userProfile', ['usuario' => $usuario, 'provincias' => $provincias]);
        } else {
            return redirect()->route('login');
        }
    }

    public function updateProfile(Request $request) 
    {
        $idUser = Session('UsuarioId');
        
        $user = Usuario::where('idUsuario', $idUser)->first();
        $userPatient = Paciente::where('Usuarios_idUsuario', $idUser)->first();
        $userProfessional = Profesional::where('Usuarios_idUsuario', $idUser)->first();
        
        if ($user && ($userPatient || $userProfessional)) {
            $userUpdates = [
                'Email' => $request->input('email'),
            ];

            if ($userPatient) {
                $userPatientUpdates = [
                    'Apellido' => $request->input('apellido'),
                    'Nombre' => $request->input('nombre'),
                    'DNI' => $request->input('dni'),
                    'Telefono' => $request->input('telefono'),
                    'Fecha_Nacimiento' => $request->input('fecha_nacimiento'),
                    'Domicilio' => $request->input('domicilio'),
                ];

                $localidad = $request->input('localidadProvincia');
                if ($localidad) {
                    $userPatientUpdates['Localidades_idLocalidad'] = $localidad;
                }

                $user->update($userUpdates);
                $userPatient->update($userPatientUpdates);

                // Recarga la información actualizada del usuario
                $updatedUser = $userPatient->refresh();
            } else if ($userProfessional) {
                $userProfessionalUpdates = [
                    'Apellido' => $request->input('apellido'),
                    'Nombre' => $request->input('nombre'),
                    'DNI' => $request->input('dni'),
                    'Telefono' => $request->input('telefono'),
                    'Fecha_Nacimiento' => $request->input('fecha_nacimiento'),
                    'Domicilio' => $request->input('domicilio'),
                ];

                $localidad = $request->input('localidadProvincia');
                if ($localidad) {
                    $userProfessionalUpdates['Localidades_idLocalidad'] = $localidad;
                }

                $user->update($userUpdates);
                $userProfessional->update($userProfessionalUpdates);

                // Recarga la información actualizada del usuario
                $updatedUser = $userProfessional->refresh();
            }

            session(['Paciente_'.$idUser => $updatedUser, 'Profesional_'.$idUser => $updatedUser]);

            return response()->json(['success' => true, 'message' => 'Actualizado con éxito']);
        } else {
            return response()->json(['error' => false, 'message' => 'Error al actualizar']);
        }
    }

}