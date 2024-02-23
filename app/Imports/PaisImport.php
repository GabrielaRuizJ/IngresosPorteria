<?php

namespace App\Imports;

use App\Models\Pais;
use Maatwebsite\Excel\Concerns\ToModel;

class PaisImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pais([
            'nombre_pais'=>$row[0],
        ]);
    }
}
