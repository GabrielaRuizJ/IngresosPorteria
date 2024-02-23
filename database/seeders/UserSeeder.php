<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Gabriela Ruiz',
            'username'=>'rgabyj',
            'cedula'=>'1000127738',
            'email'=>'gabrielazenm@gmail.com',
            'password'=>bcrypt('1000127738'),
            'estado'=>true
        ])->assignRole('Admin');

        User::create([
            'name'=>'Administrador del sistema',
            'username'=>'administrador',
            'cedula'=>'832002372',
            'email'=>'sistemas@clubpuebloviejo.com',
            'password'=>bcrypt('832002372'),
            'estado'=>true
        ])->assignRole('Admin');

        User::create([
            'name'=>'Gerencia',
            'username'=>'gerencia',
            'cedula'=>'832002372',
            'email'=>'sistemas@clubpuebloviejo.com',
            'password'=>bcrypt('832002372'),
            'estado'=>true
        ])->assignRole('Gerencia');
        
    }
}
