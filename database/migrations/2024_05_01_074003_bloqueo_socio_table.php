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
        Schema::create('bloqueo_socio', function (Blueprint $table) {
            $table->id();
            $table->string('cedula',30);
            $table->string('accion',10);
            $table->integer('tipo_bloqueo')->unsigned();
            $table->date('fecha_inicio_bloqueo')->nullable();
            $table->date('fecha_fin_bloqueo')->nullable();
            $table->boolean('indefinido')->default(false);
            $table->boolean('bloqueo_consumo')->default(false);
            $table->boolean('bloqueo_ingreso')->default(false);
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
        //
    }
};
