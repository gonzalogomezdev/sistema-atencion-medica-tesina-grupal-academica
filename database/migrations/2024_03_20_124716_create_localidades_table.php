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
        Schema::create('localidades', function (Blueprint $table) {
            $table->integer('idLocalidad', true);
            $table->string('Desc_Localidad', 45)->nullable();
            $table->integer('Provincias_idProvincia')->index('fk_Localidades_Provincias1');

            $table->primary(['idLocalidad', 'Provincias_idProvincia']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidades');
    }
};
