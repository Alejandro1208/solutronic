<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Producto extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'titulo', 'descripcion', 'imagen', 'destacado',
        'filter', 'order', 'codigo', 'configuraciones',
        'imagen2', 'imagen3', 'imagen4', 'video'
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true
    ];

    protected $casts = [
        'filter' => 'array'
    ];

public function productFilters()
{
    return $this->hasMany(ProductFilter::class);
}

    public function media()
    {
        return $this->hasMany(Media::class, 'product_id');
    }
}