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
        Schema::create('detalle_canje', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ingreso')->unsigned();
            $table->integer('id_club')->unsigned();
            $table->string('cedula_canje',30);
            $table->string('nombre_club',120);
            $table->date('fecha_inicio_canje');
            $table->date('fecha_fin_canje');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_canje');
    }
};
