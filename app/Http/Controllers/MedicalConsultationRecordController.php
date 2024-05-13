<?php

namespace App\Http\Controllers;

use App\Models\MedicalConsultationRecord;
use Illuminate\Http\Request;

use App\Models\Paciente;
use App\Models\Usuario;
use App\Models\EstadoHistoriales;
use Carbon\Carbon;
use App\Models\MedicalHistory;

class MedicalConsultationRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $patients = Paciente::all();

        return view('dashboard.doctor.medicalConsultationRecord',['pacientes' => $patients]); 

      /*   $historys = MedicalConsultationRecord::all();  


        

        return view('historiales.index', ['pacientes' => $patients]); */
        /* $historys = MedicalConsultationRecord::all();   

        $patients = Paciente::select('Nombre', 'Apellido')
        ->whereExists(function ($query) {
            $query->select('Usuarios_idUsuario')
                  ->from('historiales_clinicos')
                  ->whereColumn('historiales_clinicos.Usuarios_idUsuario', 'pacientes.idPaciente');
        })
        ->distinct()
        ->get();

    return view('dashboard.doctor.medicalHistory.index', ['patients' => $patients, 'historys' => $historys]);
          */   

         /*  $patients = Pacientm e::has('historialesClinicos')->get();

          return view('dashboard.doctor.medicalHistory.index', ['patients' => $patients] ); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'Usuarios_idUsuario');
    }

    public function store(Request $request)
    {

        
        $request->validate([
            'paciente' => 'required'
        ]);

        

        $idPaciente = $request->input('paciente');
        

        // Obtener el paciente
        $paciente = Paciente::findOrFail($idPaciente);
        

        $idUsuario = $paciente->Usuarios_idUsuario;  
        
       
        $historialClinico = MedicalHistory::create([
                'Pacientes_idPaciente' => $paciente->idPaciente,
                'Diagnostico' => $request->input('Diagnostico'),
                'Tratamiento' => $request->input('Tratamiento'),
                'Medicamento' => $request->input('Medicamento'),
                'Estados_Historiales_idEstado_Historial' => '1',
                'Fecha' => Carbon::now(),
         ]);

         
         return redirect()->route('dashboardDoctor'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalConsultationRecord  $medicalConsultationRecord
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalConsultationRecord $medicalConsultationRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalConsultationRecord  $medicalConsultationRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalConsultationRecord $medicalConsultationRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalConsultationRecord  $medicalConsultationRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalConsultationRecord $medicalConsultationRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalConsultationRecord  $medicalConsultationRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalConsultationRecord $medicalConsultationRecord)
    {
        //
    }
}
