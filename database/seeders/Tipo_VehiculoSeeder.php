<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo_Vehiculo;

class Tipo_VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo_Vehiculo::create([
            'nombre_vehiculo'=>'Automovil'
        ]);
        Tipo_Vehiculo::create([
            'nombre_vehiculo'=>'Moto'
        ]);
        Tipo_Vehiculo::create([
            'nombre_vehiculo'=>'Sin vehiculo'
        ]);
    
    }
}
