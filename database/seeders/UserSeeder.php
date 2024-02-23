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
            'name'=>'Gabriela Ruiz J',
            'username'=>'gabydev',
            'cedula'=>'1000127737',
            'email'=>'gabrielazenm@gmail.com',
            'password'=>bcrypt('1000127737'),
            'estado'=>true
        ])->assignRole('Gerencia');
        
    }
}
