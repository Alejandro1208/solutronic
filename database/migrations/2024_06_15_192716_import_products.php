<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $file = fopen(database_path('products.csv'), 'r');
    
        // Saltar la primera línea si tiene encabezados de columna
        fgetcsv($file);
    
        while (($data = fgetcsv($file, 0, ';')) !== false) {
            $productData = [
                'categoria' => $data[0],
                'filter' => $data[1],
                'titulo' => $data[2],
                'configuraciones' => $data[3],
                'codigo' => $data[4],
                'descripcion' => $data[5],
                'enlace' => $data[6],
            ];
        
            \Illuminate\Support\Facades\Log::info('Creating product: ', $productData);
        
            \App\Models\Producto::create($productData);
        }
        fclose($file);
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
