<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Horario;
use App\Models\Turno;
use App\Models\Paciente;
use App\Models\Profesional;
use App\Models\Usuario;

use App\Models\TurnosBloqueados;

class AppointmentController extends Controller
{
    public function shiftCalendar(){
        $idUser = Session('UsuarioId');

        $professional = Session('Profesional_' . $idUser);
        $patient = Session('Paciente_' . $idUser);

        $idProfessional = null;
        $idPatient = null;

        if ($professional) {
            $idProfessional = Profesional::where('Usuarios_idUsuario', $idUser)->first();
            $listPatients = Paciente::select('*')->get();
        } else if ($patient) {
            $idPatient = Paciente::where('Usuarios_idUsuario', $idUser)->first();
            $listPatients = null; 
        }

        return view('calendar.calendarTurnos', ['idPatient' => $idPatient, 'idProfessional' => $idProfessional, 'listPatients' => $listPatients]);
        
    }
    
    public function getAvailableSlots(Request $request) {
        $date = $request->date;
        
        // Obtener los horarios disponibles para la fecha seleccionada
        $horariosDisponibles = Horario::orderBy('Hora')->get();

        // Array para almacenar los resultados
        $availableSlots = [];

        // Iterar sobre cada horario y verificar si existe un turno asociado en la fecha seleccionada
        foreach ($horariosDisponibles as $horario) {
            // Verificar si hay algún turno asociado con este horario para la fecha seleccionada
            $turnoAsociado = Turno::where('Horarios_idHorarios', $horario->idHorarios)
            ->whereDate('Fecha', $date)
            ->first();

            $turnoBloqueado = TurnosBloqueados::whereDate('Fecha', $date)->exists();

            if ($turnoBloqueado) {
                // Si la fecha está bloqueada, devolver un mensaje indicando que está bloqueada
                return response()->json(['message' => 'Esta fecha está bloqueada.'], 200);
            }        

            // 0 disponible
            // 1 reservado

            // Si no hay un turno asociado, agregamos este horario como disponible
            if (!$turnoAsociado) {
                // Agregamos los datos del horario y también la fecha del turno si está disponible
                $availableSlots[] = [
                    'idTurno' => null,
                    'Fecha' => $date,
                    'Hora' => $horario->Hora,
                    'Franja_Horaria' => $horario->Franja_Horaria,
                    'Estado' => 'Disponible',
                    'Paciente' => null,
                ];
            } else {
                // Si hay un turno asociado, lo agregamos junto con su estado
                $availableSlots[] = [
                    'idTurno' => $turnoAsociado->idTurno,
                    'Fecha' => $date,
                    'Hora' => $horario->Hora,
                    'Franja_Horaria' => $horario->Franja_Horaria,
                    'Estado' => $turnoAsociado->Estado_Turno != 0 ? 'No disponible' : 'Disponible',
                    'Paciente' => $turnoAsociado->Pacientes_idPaciente,
                ];
            }
        }

        return response()->json($availableSlots);
    }
    
    public function saveAppointment(Request $request)
    {
        $Fecha = $request->input('Fecha');
        $Hora = $request->input('Hora');
        $Pacientes_idPaciente = $request->input('Pacientes_idPaciente');
        $Estado_Turno = 1;
        $Horarios_idHorarios = Horario::where('Hora', $Hora)->value('idHorarios');

        if (!$Horarios_idHorarios) {
            return response()->json(['error' => 'No se encontró ningún horario para la hora proporcionada'], 404);
        }

        // Verificar si el paciente ya tiene un turno reservado para el día dado
        $existeTurno = Turno::where('Fecha', $Fecha)
        ->where('Pacientes_idPaciente', $Pacientes_idPaciente)
        ->where('Estado_Turno', '=', 1)
        ->exists();

        if ($existeTurno) {
            // Si ya tiene un turno reservado y no está cancelado, devuelve un mensaje de error
            return response()->json(['error' => 'Ya has reservado un turno para este día'], 400);
        } else {
            // Si no tiene un turno reservado o el turno anterior está cancelado, permite que reserve el turno
            $turno = Turno::create([
                'Fecha' => $Fecha,
                'Estado_Turno' => $Estado_Turno,
                'Pacientes_idPaciente' => $Pacientes_idPaciente,
                'Horarios_idHorarios' => $Horarios_idHorarios
            ]);
        }
    }

    public function cancelAppointment(Request $request)
    {
        $turnoId = $request->input('turnoId'); // Obtener el ID del turno a cancelar desde la solicitud

        $turno = Turno::find($turnoId);

        if (!$turno) {
            return response()->json(['error' => 'El turno no existe'], 404);
        } else if ($turno) {
            $turno->delete();
        }

        return response()->json(['message' => 'El turno ha sido cancelado exitosamente'], 200);
    }

    public function blockAppointment(Request $request) 
    {
        $Fecha = $request->input('Fecha');
        
        $turno = TurnosBloqueados::create([
            'Fecha' => $Fecha,
            'Franja_Horaria' => null,
        ]);
        
        return response()->json(['message' => 'El dia se bloqueo exitosamente'], 200);
    }

    public function unblockAppointment(Request $request) 
    {
        $fecha = $request->input('fecha');

        // Buscar y eliminar la entrada correspondiente en la tabla turnos_bloqueados
        TurnosBloqueados::where('Fecha', $fecha)->delete();
        
        return response()->json(['message' => 'El día se desbloqueó exitosamente'], 200);
    }
        
}
