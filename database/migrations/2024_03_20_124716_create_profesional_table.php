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
        Schema::create('profesional', function (Blueprint $table) {
            $table->integer('idProfesional', true);
            $table->string('Nombre', 80)->nullable();
            $table->string('Apellido', 80)->nullable();
            $table->string('DNI', 10)->nullable();
            $table->string('Telefono', 15)->nullable();
            $table->date('Fecha_Nacimiento')->nullable();
            $table->string('Domicilio', 45)->nullable();
            $table->integer('Localidades_idLocalidad')->index('fk_Profesional_Localidades1');
            $table->integer('Generos_idGenero')->index('fk_Profesional_Generos1');
            $table->integer('Estados_Civiles_idEstado_Civil')->index('fk_Profesional_Estados_Civiles1');
            $table->integer('Usuarios_idUsuario')->index('fk_Profesional_Usuarios1');

            $table->primary(['idProfesional', 'Localidades_idLocalidad', 'Generos_idGenero', 'Estados_Civiles_idEstado_Civil', 'Usuarios_idUsuario']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesional');
    }
};
