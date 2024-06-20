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
        Schema::create('autorizado', function (Blueprint $table) {
            $table->id();
            $table->string('cedula_autorizado',30);
            $table->string('nombre_autorizado',100);
            $table->string('cedula_autoriza',30);
            $table->string('nombre_autoriza',100);
            $table->boolean('estado')->default(true);
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_fin_ingreso')->nullable();
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
        Schema::dropIfExists('autorizado');
    }
};
