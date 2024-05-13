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
        Schema::create('turnos_bloqueados', function (Blueprint $table) {
            $table->integer('idTurnoBloqueado');
            $table->date('Fecha')->nullable();
            $table->string('Franja_Horaria', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turnos_bloqueados');
    }
};
