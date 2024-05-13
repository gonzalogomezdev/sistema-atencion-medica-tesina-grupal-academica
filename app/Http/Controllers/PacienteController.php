<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Usuario;

class PacienteController extends Controller
{

	public function showPatients()
	{
    	$patients = Paciente::where('Roles_idRol', 1)
		->where('Estados_Pacientes_idEstado', 2)
		->whereHas('getUsuario', function ($query) {
			$query->where('Email_verified', 1);
		})
		->get();

        return view('dashboard.doctor.patientsRequests', ['pacientes' => $patients]);
	}

	// El objeto $request es una instancia de la clase Illuminate\Http\Request en Laravel, y se utiliza para acceder a los datos de la solicitud HTTP actual, como parámetros de URL, datos de formularios POST, encabezados HTTP, etc. $request->input('paciente_id') en este caso se utiliza para obtener el valor del parámetro 'paciente_id' enviado en la solicitud Ajax.
	public function updatePatient(Request $request) 
	{
		$idPatient = $request->input('id');

		$patient = Paciente::find($idPatient); //Busca al paciente con ese id

		if ($patient) {
			$patient->Roles_idRol = 2;
			$patient->Estados_Pacientes_idEstado = 1;
			
			$patient->save();

			return response()->json(['message' => 'Dado de alta correctamente']);
		} else {
			return response()->json(['message' => 'No se encontró al paciente.'], 404);
		}
	}

	public function deletePatient($id) 
	{
		$patient = Paciente::find($id);

		if ($patient) {
			$patient->delete();

			$user = Usuario::find($patient->Usuarios_idUsuario);

			if ($user) {
				$user->delete();
			}

			return response()->json(['message' => "Paciente eliminado"]);
		} else {
			return response()->json(['message' => "Error"]);
		}
	}

	public function newPatient(Request $request){
		try {

			$idUserNotAccount= 36;
			
			$patient = $request;

			$patient = Paciente::create([
				'Apellido' => $patient->apellido,
				'Nombre' => $patient->nombre ,
				'DNI' => $patient->dni,
				'Telefono' =>  null,
				'Domicilio' =>  null,
				'Fecha_Nacimiento' => null,
				'Localidades_idLocalidad' => 1,
				'Generos_idGenero' => 1, 
				'Estados_Civiles_idEstado_Civil' => 1, 
				'Roles_idRol' => 1, 
				'Estados_Pacientes_idEstado' => 1,
				'Usuarios_idUsuario' => $idUserNotAccount
			 ]);	

			 return redirect()->route('dashboardDoctor');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }	
	}
}
