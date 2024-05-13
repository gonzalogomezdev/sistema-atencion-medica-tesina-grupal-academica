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
        Schema::table('pacientes', function (Blueprint $table) {
            $table->foreign(['Roles_idRol'], 'fk_Pacientes_Roles1')->references(['idRol'])->on('roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Estados_Civiles_idEstado_Civil'], 'fk_Usuarios_Estados_Civiles1')->references(['idEstado_Civil'])->on('estados_civiles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Localidades_idLocalidad'], 'fk_Usuarios_Localidades1')->references(['idLocalidad'])->on('localidades')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Estados_Pacientes_idEstado'], 'fk_Pacientes_Estados_Pacientes1')->references(['idEstado'])->on('estados_pacientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Usuarios_idUsuario'], 'fk_Pacientes_Usuarios1')->references(['idUsuario'])->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Generos_idGenero'], 'fk_Usuarios_Generos1')->references(['idGenero'])->on('generos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropForeign('fk_Pacientes_Roles1');
            $table->dropForeign('fk_Usuarios_Estados_Civiles1');
            $table->dropForeign('fk_Usuarios_Localidades1');
            $table->dropForeign('fk_Pacientes_Estados_Pacientes1');
            $table->dropForeign('fk_Pacientes_Usuarios1');
            $table->dropForeign('fk_Usuarios_Generos1');
        });
    }
};
