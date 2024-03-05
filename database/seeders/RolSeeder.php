<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=>'Admin']);
        $role2 = Role::create(['name'=>'Gerencia']);
        
        Permission::create(['name'=>'user'])->assignRole($role1);
        Permission::create(['name'=>'user.create'])->assignRole($role1);

        Permission::create(['name'=>'role'])->assignRole($role1);
        Permission::create(['name'=>'role.create'])->assignRole($role1);

        Permission::create(['name'=>'permiso'])->assignRole($role1);
        Permission::create(['name'=>'permiso.create'])->assignRole($role1);
        
        Permission::create(['name'=>'paises'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'paise.create'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'ciudades'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'ciudad.create'])->assignRole($role1);
        Permission::create(['name'=>'ciudad.edit'])->assignRole($role1);

        Permission::create(['name'=>'clubes'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'club.create'])->syncRoles([$role1,$role2]);
        
    }
}
