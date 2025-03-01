<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;
use App\Models\Media;

class ProductoController extends Controller
{
public function all()
{
    $productos = Producto::with('media')->get();
    return view('product_list', compact('productos'));
}
/**
 * Display the specified resource.
 */
public function showProductos(Request $request)
{
    try {
        $query = Producto::with(['media', 'filters'])->orderBy('order', 'asc');

        // Handle filters
        if ($request->has('filters') && !empty($request->input('filters'))) {
            $filters = $request->input('filters');
            $query->where(function($q) use ($filters) {
                foreach ($filters as $filter) {
                    $q->orWhere('filter', 'LIKE', "%$filter%")
                      ->orWhereHas('filters', function($subQ) use ($filter) {
                          $subQ->where('filter', $filter)
                              ->orWhere('parent_filter', $filter);
                      });
                }
            });
        }

        // Handle search
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        $productos = $query->paginate(9);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.product-list', compact('productos'))->render(),
                'pagination' => $productos->links()->toHtml(),
                'count' => $productos->count()
            ]);
        }

        return view('productos', compact('productos'));
    } catch (\Exception $e) {
        Log::error('Error en showProductos:', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'error' => 'Error al cargar los productos'
            ], 500);
        }
        return back()->with('error', 'Error al cargar los productos');
    }
}

public function show(Producto $producto)
{
    return $this->showProductos(request());
}
}