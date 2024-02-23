<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class UsuarioImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $usuariosData = [];
    public function model(array $row)
    {
        return new User([
            'name'=>$row[0],
            'username'=>$row[1],
            'cedula'=>$row[2],
            'email'=>$row[3],
            'password'=>Hash::make($row[2])
        ]);
    }
    public function getUsuariosData()
    {
        return $this->usuariosData;
    }
}
