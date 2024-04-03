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
        Permission::create(['name'=>'user.edit'])->assignRole($role1);
        Permission::create(['name'=>'user.destroy'])->assignRole($role1);

        Permission::create(['name'=>'role'])->assignRole($role1);
        Permission::create(['name'=>'role.create'])->assignRole($role1);
        Permission::create(['name'=>'role.edit'])->assignRole($role1);
        Permission::create(['name'=>'role.destroy'])->assignRole($role1);

        Permission::create(['name'=>'permiso'])->assignRole($role1);
        Permission::create(['name'=>'permiso.create'])->assignRole($role1);
        Permission::create(['name'=>'permiso.edit'])->assignRole($role1);
        Permission::create(['name'=>'permiso.destroy'])->assignRole($role1);
        
        Permission::create(['name'=>'pais'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'pais.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'pais.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'pais.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'ciudades'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'ciudad.create'])->assignRole($role1);
        Permission::create(['name'=>'ciudad.edit'])->assignRole($role1);
        Permission::create(['name'=>'ciudad.destroy'])->assignRole($role1);

        Permission::create(['name'=>'clubes'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'club.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'club.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'club.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'tipo_ingreso'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'tipo_ingreso.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'tipo_ingreso.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'tipo_ingreso.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'tipo_vehiculo'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'tipo_vehiculo.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'tipo_vehiculo.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'tipo_vehiculo.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'ingresos'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'ingreso.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'ingreso.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'ingreso.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'salidas'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'salida.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'salida.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'salida.destroy'])->syncRoles([$role1]);
        
    }
}
