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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_club',120);
            $table->string('direccion',120);
            $table->string('telefono',60);
            $table->string('email1',100);
            $table->string('email2',100);
            $table->unsignedBigInteger('id_ciudad');
            $table->foreign('id_ciudad')->references('id')->on('ciudad');
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
        Schema::table('clubs',function (Blueprint $table) {
            $table->dropForeign(['id_ciudad']);
            $table->dropColumn('id_pais');
        });
        
        Schema::dropIfExists('clubs');
       
    }
};
