<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->integer('idTurno', true);
            $table->date('Fecha')->nullable();
            $table->integer('Estado_Turno')->nullable();
            $table->integer('Horarios_idHorarios')->index('fk_Turnos_Horarios1');
            $table->integer('Pacientes_idPaciente')->index('fk_Turnos_Pacientes1');

            $table->primary(['idTurno', 'Horarios_idHorarios', 'Pacientes_idPaciente']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turnos');
    }
};
