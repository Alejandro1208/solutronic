<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descripcion', 'imagen', 'destacado', 'filter', 'order', 'codigo', 'configuraciones', 'imagen2', 'imagen3', 'imagen4', 'video'];

    public function media()
    {
        return $this->hasMany(Media::class, 'product_id');
    }
}