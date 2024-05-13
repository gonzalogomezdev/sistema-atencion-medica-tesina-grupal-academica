<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Usuario;
use App\Models\MedicalHistory;
use App\Models\EstadoHistoriales;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;




class MedicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los pacientes que tienen al menos un historial clínico
        $patients = Paciente::has('medicalHistory')->get();
        
        // Verificar si hay pacientes con historial médico
        if ($patients->isEmpty()) {
            return response()->json(['message' => 'No hay pacientes con historial médico.'], 200);
        }

        foreach ($patients as $patient) {
            $medicalHistories = $patient->medicalHistory;

            foreach ($medicalHistories as $history) {
                // Obtener el estado del historial médico
                $estadoHistorial = EstadoHistoriales::find($history->Estados_Historiales_idEstado_Historial);
                
                // Agregar el estado del historial médico al historial médico
                $history->estadoHistorial = $estadoHistorial;
            }

            $data[] = [
                'patient' => $patient->toArray(),
                'historiales' => $medicalHistories->toArray()
            ];

            // Obtener todos los estados de historiales
            $estadosHistoriales = EstadoHistoriales::all();
        }

        return view('dashboard.doctor.medicalHistory', ['patientsWithMedicalHistory' => $patients, 'medicalHistorys' => $data, 'estadosHistoriales' => $estadosHistoriales]);
    }

    public function verHistorial($idPaciente)
    {
        $paciente = Paciente::findOrFail($idPaciente);
        $historialesClinicos = MedicalHistory::where('Pacientes_idPaciente', $idPaciente)->get();
        dd($historialesClinicos);
        /* return view('historial', ['historialesClinicos' => $historialesClinicos]); */
    }

    public function actualizarEstado(Request $request)
    {
        try {
            $historial = MedicalHistory::findOrFail($request->historial_id);
            $historial->Estados_Historiales_idEstado_Historial = $request->estado_tratamiento;
            $historial->save();
    
            return redirect()->route('dashboardDoctor');;
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }    
   

    public function pdf(Request $request){

       /*  $historialClinico = MedicalHistory::all(); */

      

       $historial = MedicalHistory::findOrFail($request->id);

       $paciente = Paciente::findOrFail($historial->Pacientes_idPaciente);

       $fechaPDF = now();
    
        $pdf = Pdf::loadView('dashboard.doctor.pdf',  
        [
         'historial' => $historial,
         'paciente' =>$paciente,
         'fechaPDF' => $fechaPDF
        ])->setPaper('a5', 'portrait');

        return $pdf->stream();
    }
}
