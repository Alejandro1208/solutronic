<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Primero, asegurarse de que los datos existentes sean JSON válidos
        $productos = DB::table('productos')->get();
        foreach ($productos as $producto) {
            if ($producto->filter && !is_null($producto->filter)) {
                // Convertir el valor actual a un array JSON válido
                $filterValue = json_encode([$producto->filter]);
                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update(['filter' => $filterValue]);
            }
        }

        // Luego cambiar el tipo de columna
        Schema::table('productos', function (Blueprint $table) {
            $table->json('filter')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('filter')->nullable()->change();
        });
    }
};
