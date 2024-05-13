<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function showDashboard($view)
    {
        $idUser = Session('UsuarioId');

        $professional = Session('Profesional_' . $idUser);
        $patient = Session('Paciente_' . $idUser);

        if ($professional || $patient) {
            return view($view, ['profesional' => $professional, 'paciente' => $patient]);
        } else {
            return redirect()->route('login');
        }
    }

    public function showDashboardPatient()
    {
        return $this->showDashboard('dashboard.paciente.dashboardPatient');
    }

    public function showDashboardDoctor()
    {
        return $this->showDashboard('dashboard.doctor.dashboardDoctor');
    }
}

