<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;
use App\Models\Profesional;
use App\Models\Mensaje;
use App\Models\Paciente;

class MensajeController extends Controller
{
    public function showMessages(Request $request)
    {
        $idUser = Session('UsuarioId');

        $professional = Session('Profesional_' . $idUser);
        $patient = Session('Paciente_' . $idUser);

        $usersWithMessages = [];

        $search = $request->input('search');

        if ($professional) {
            $listUsers = Usuario::where('idUsuario', '!=', $idUser)
            ->get();
            
            foreach ($listUsers as $user) {
                $userLastMessage = Mensaje::where('Remitente_id', $idUser) //Usuario actual en la session
                ->where('Destinatario_id', $user->idUsuario) //Usuario actual en el bucle 
                ->orWhere('Remitente_id', $user->idUsuario)  
                ->Where('Destinatario_id', $idUser) 
                ->orderBy('Fecha_Hora', 'desc')
                ->first();

                if ($userLastMessage) {
                    $user->userLastMessage = $userLastMessage->Mensaje;
                    $user->userDateMessage = $userLastMessage->Fecha_Hora;
                    $usersWithMessages[] = $user;
                } else {
                    $user->userLastMessage = 'Sin mensajes';
                    $usersWithMessages[] = $user; // Incluimos a usuarios sin mensajes
                }
            }

            $searchPatients = Paciente::whereHas('getUsuario', function ($query) use ($search) {
                $query->where('Nombre', 'like', "%$search%")
                      ->orWhere('Apellido', 'like', "%$search%");
            })->with('getUsuario')->get(); 
            
            $resultsPatients = $searchPatients;

        } elseif($patient) {
            // $sql = Profesional::first(); // Pensado para un solo profesional
            // $listUsers = Usuario::where('idUsuario', $sql->Usuarios_idUsuario)->get();
            
            $sql = Profesional::select('*')->get(); // Pensado para más profesionales
            $listUsers = collect([]);

            foreach ($sql as $userProfessional) {
                $users = Usuario::where('idUsuario', $userProfessional->Usuarios_idUsuario)->get();
                $listUsers = $listUsers->merge($users);
            }

            foreach ($listUsers as $user) {
                $userLastMessage = Mensaje::where('Remitente_id', $idUser) //Usuario actual en la session
                ->where('Destinatario_id', $user->idUsuario) //Usuario actual en el bucle 
                ->orWhere('Remitente_id', $user->idUsuario)  
                ->Where('Destinatario_id', $idUser) 
                ->orderBy('Fecha_Hora', 'desc')
                ->first();

                if ($userLastMessage) {
                    $user->userLastMessage = $userLastMessage->Mensaje;
                    $user->userDateMessage = $userLastMessage->Fecha_Hora;
                    $usersWithMessages[] = $user;
                } else {
                    $user->userLastMessage = 'Sin mensajes';
                    $usersWithMessages[] = $user;
                }
            }

            $searchProfessional = Profesional::whereHas('getUsuario', function ($query) use ($search) {
                $query->where('Nombre', 'like', "%$search%")
                      ->orWhere('Apellido', 'like', "%$search%");
            })->with('getUsuario')->get(); 

            $resultsProfessional = $searchProfessional;
        }
        
        // $usersWithMessages contiene solo los usuarios con mensajes asociados y sin mensajes
        $listMessages = collect($usersWithMessages)->sortByDesc('userDateMessage');
        
        if($search) {
            $usuario = $resultsPatients ?? $resultsProfessional;
            return response()->json(['users' => $usuario]);   
        } else {
            return view('mensajes.mensajes', ['users' => $listMessages, 'professional' => $professional, 'patient' => $patient]);
        }
        
    }

    public function getConversation(Request $request) {
        $idUser = Session('UsuarioId');

        $professional = Session('Profesional_' . $idUser);
        $patient = Session('Paciente_' . $idUser);

        $idConver = $request->input('id'); 

        if ($professional) {
            $conver = Mensaje::where('Remitente_id', $idUser)
            ->where('Destinatario_id', $idConver)
            ->orWhere('Remitente_id', $idConver)
            ->where('Destinatario_id', $idUser)
            ->orderBy('Fecha_Hora', 'asc')
            ->get();
        } elseif ($patient) {
            $conver = Mensaje::where('Remitente_id', $idUser)
            ->where('Destinatario_id', $idConver)
            ->orWhere('Remitente_id', $idConver)
            ->where('Destinatario_id', $idUser)
            ->orderBy('Fecha_Hora', 'asc')
            ->get();
        }

        foreach ($conver as $message) {
            $remitente = Usuario::where('idUsuario', $message->Remitente_id)->first();
            if ($remitente) {
                if ($remitente->getPaciente) {
                    $message->remitente_name = $remitente->getPaciente->Nombre;
                } elseif ($remitente->getProfesional) {
                    $message->remitente_name = $remitente->getProfesional->Nombre;
                } else {
                    $message->remitente_name = 'Desconocido';
                }
            } else {
                $message->remitente_name = 'Desconocido';
            }
        }

        return response()->json(['messages' => $conver]);
    }

    public function storeMessage(Request $request) 
    {
        $idUser = Session('UsuarioId');
        
        $message = Mensaje::create([
            'Mensaje' => $request->input('Message'),
            'Fecha_Hora' => now(),
            'Remitente_id' => $idUser,
            'Destinatario_id' => $request->input('UserId')
        ]);
        
        // Recuperar el nombre del remitente
        $remitente = Usuario::find($idUser);
        $remitente_name = $remitente ? ($remitente->getPaciente ? $remitente->getPaciente->Nombre : ($remitente->getProfesional ? $remitente->getProfesional->Nombre : 'Desconocido')) : 'Desconocido';
        
        return response()->json([
            'remitente_name' => $remitente_name,
            'Mensaje' => $message->Mensaje,
            'Fecha_Hora' => $message->Fecha_Hora
        ]);
    }
}
