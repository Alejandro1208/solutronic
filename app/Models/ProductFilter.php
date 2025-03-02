<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Model
{
    protected $fillable = ['product_id', 'filter', 'parent_filter'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }
}