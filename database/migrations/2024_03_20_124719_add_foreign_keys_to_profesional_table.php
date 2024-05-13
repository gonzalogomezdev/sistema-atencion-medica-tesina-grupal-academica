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
        Schema::table('profesional', function (Blueprint $table) {
            $table->foreign(['Generos_idGenero'], 'fk_Profesional_Generos1')->references(['idGenero'])->on('generos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Usuarios_idUsuario'], 'fk_Profesional_Usuarios1')->references(['idUsuario'])->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Estados_Civiles_idEstado_Civil'], 'fk_Profesional_Estados_Civiles1')->references(['idEstado_Civil'])->on('estados_civiles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['Localidades_idLocalidad'], 'fk_Profesional_Localidades1')->references(['idLocalidad'])->on('localidades')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profesional', function (Blueprint $table) {
            $table->dropForeign('fk_Profesional_Generos1');
            $table->dropForeign('fk_Profesional_Usuarios1');
            $table->dropForeign('fk_Profesional_Estados_Civiles1');
            $table->dropForeign('fk_Profesional_Localidades1');
        });
    }
};
