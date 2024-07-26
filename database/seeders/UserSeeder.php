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
            'name'=>'Administrador',
            'username'=>'admin',
            'cedula'=>'8320023721',
            'email'=>'sistemas@clubpuebloviejo.com',
            'password'=>bcrypt('832002372'),
            'estado'=>true
        ])->assignRole('Admin');
        
    }
}
