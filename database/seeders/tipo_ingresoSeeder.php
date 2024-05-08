<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo_ingreso;

class tipo_ingresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo_Ingreso::create([
            'nombre_ingreso'=>'Socio'
        ]);
        Tipo_Ingreso::create([
            'nombre_ingreso'=>'Invitado'
        ]);
        Tipo_Ingreso::create([
            'nombre_ingreso'=>'Canje'
        ]);
        Tipo_Ingreso::create([
            'nombre_ingreso'=>'Autorizado'
        ]);
    }
}
