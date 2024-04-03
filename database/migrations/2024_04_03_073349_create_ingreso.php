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
        Schema::create('ingreso', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_ingreso');
            $table->time('hora_ingreso');
            $table->unsignedBigInteger('id_tipo_vehiculo');
            $table->foreign('id_tipo_vehiculo')->references('id')->on('tipo_vehiculo')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_tipo_ingreso');
            $table->foreign('id_tipo_ingreso')->references('id')->on('tipo_ingreso')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('cedula',30);
            $table->string('nombre',150);
            $table->boolean('estado')->default(true)->nullable();
            $table->date('fecha_salida')->nullable();
            $table->time('hora_salida')->nullable();
            $table->unsignedBigInteger('id_usuario_create');
            $table->foreign('id_usuario_create')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_usuario_update')->nullable();
            $table->foreign('id_usuario_update')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('ingreso');
    }
};
