<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;

class UsuarioCollectionImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    protected $usuariosData = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Asume que el archivo CSV tiene columnas 'email' y 'rol'
            $name = $row[0];
            $username = $row[1];
            $cedula = $row[2];
            $email = $row[3];
            $password = Hash::make($row[2]);
            $rol = $row[5]; 

            $this->usuariosData[] = [
                'name' => $name,
                'username' => $username,
                'cedula' => $cedula,
                'email' => $email,
                'password'=>$password,
                'rol' => $rol,
            ];
        }
    }

    public function getUsuariosData()
    {
        return $this->usuariosData;
    }
}
