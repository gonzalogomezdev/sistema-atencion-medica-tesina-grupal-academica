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
        Schema::table('historiales_clinicos', function (Blueprint $table) {
            $table->foreign(['Pacientes_idPaciente'], 'fk_Historiales_Clinicos_Usuarios1')->references(['idPaciente'])->on('pacientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Estados_Historiales_idEstado_Historial'], 'fk_Historiales_Clinicos_Estados_Historiales1')->references(['idEstado_Historial'])->on('estados_historiales')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historiales_clinicos', function (Blueprint $table) {
            $table->dropForeign('fk_Historiales_Clinicos_Usuarios1');
            $table->dropForeign('fk_Historiales_Clinicos_Estados_Historiales1');
        });
    }
};
