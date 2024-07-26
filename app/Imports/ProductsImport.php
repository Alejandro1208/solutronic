<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
{
    return new Product([
        'categoria' => $row[0],
        'subcategoria' => $row[1],
        'producto' => $row[2],
        'configuraciones' => $row[3],
        'codigo' => $row[4],
        'descripcion' => $row[5],
    ]);
}
}
