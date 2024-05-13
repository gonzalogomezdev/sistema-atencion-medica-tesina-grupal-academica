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
        Schema::create('historiales_clinicos', function (Blueprint $table) {
            $table->integer('idHistorial', true);
            $table->text('Diagnostico')->nullable();
            $table->text('Tratamiento')->nullable();
            $table->text('Medicamento')->nullable();
            $table->date('Fecha');
            $table->integer('Pacientes_idPaciente')->index('fk_Historiales_Clinicos_Usuarios1');
            $table->integer('Estados_Historiales_idEstado_Historial')->index('fk_Historiales_Clinicos_Estados_Historiales1');

            $table->primary(['idHistorial', 'Pacientes_idPaciente', 'Estados_Historiales_idEstado_Historial']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historiales_clinicos');
    }
};
