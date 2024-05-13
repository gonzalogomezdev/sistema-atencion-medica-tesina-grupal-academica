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
        Schema::table('turnos', function (Blueprint $table) {
            $table->foreign(['Pacientes_idPaciente'], 'fk_Turnos_Pacientes1')->references(['idPaciente'])->on('pacientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Horarios_idHorarios'], 'fk_Turnos_Horarios1')->references(['idHorarios'])->on('horarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->dropForeign('fk_Turnos_Pacientes1');
            $table->dropForeign('fk_Turnos_Horarios1');
        });
    }
};
