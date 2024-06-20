<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bloqueo;

class BloqueoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bloqueo::create([
            'nombre_bloqueo'=>'Pago cartera',
            'id_usuario_create'=>'1'
        ]);
    }
}
