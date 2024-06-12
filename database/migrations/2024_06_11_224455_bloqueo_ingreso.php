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
        Schema::create('bloqueo_ingreso', function (Blueprint $table) {
            $table->id();
            $table->string('cedula',50);
            $table->integer('tipo_bloqueo')->unsigned();
            $table->boolean('estado')->default(true);
            $table->boolean('indefinido')->default(false);
            $table->date('fecha_inicio_bloqueo')->nullable();
            $table->date('fecha_fin_bloqueo')->nullable();
            $table->boolean('bloqueo_consumo')->default(false);
            $table->boolean('bloqueo_ingreso')->default(false);
            $table->integer('id_usuario_create')->unsigned()->nullable();
            $table->integer('id_usuario_update')->unsigned()->nullable();
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
        Schema::dropIfExists('bloqueo_ingreso');
    }
};
