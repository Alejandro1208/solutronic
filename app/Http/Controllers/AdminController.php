<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Media;

class AdminController extends Controller
{
// Asegura que solo usuarios autenticados puedan acceder a los métodos de este controlador
public function __construct()
{
    $this->middleware('auth');
}

public function index(Request $request)
{
    try {
        $query = Producto::with('media')->orderBy('order', 'asc');

        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            Log::info('Búsqueda iniciada con término:', ['searchTerm' => $searchTerm]);
            
            if (!empty($searchTerm)) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('titulo', 'like', "%{$searchTerm}%")
                      ->orWhere('descripcion', 'like', "%{$searchTerm}%")
                      ->orWhere('codigo', 'like', "%{$searchTerm}%")
                      ->orWhere('configuraciones', 'like', "%{$searchTerm}%");
                });
            }
            
            $productos = $query->paginate(12)->withQueryString();
            Log::info('Productos encontrados:', [
                'total' => $productos->total(),
                'por_página' => $productos->perPage(),
                'página_actual' => $productos->currentPage()
            ]);
            
            if ($request->ajax()) {
                $response = [
                    'success' => true,
                    'html' => view('admin', [
                        'productos' => $productos,
                        'ordenando' => false
                    ])->render(),
                    'pagination' => $productos->links()->toHtml()
                ];
                Log::info('Respuesta AJAX preparada:', [
                    'tiene_html' => !empty($response['html']),
                    'tiene_paginacion' => !empty($response['pagination'])
                ]);
                return response()->json($response);
            }
        }
        else {
            $productos = $query->paginate(12);
        }

        return view('admin', [
            'productos' => $productos,
            'ordenando' => false
        ]);
    } catch (\Exception $e) {
        \Log::error('Error en búsqueda:', ['error' => $e->getMessage()]);
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
        return back()->with('error', 'Error al cargar los productos');
    }
}

public function getProductData(Producto $producto)
{
    \Log::info('Iniciando getProductData para producto ID: ' . $producto->id);

    $producto->load(['media', 'productFilters']);
    \Log::info('Relaciones cargadas. Filters:', ['filters_raw' => $producto->productFilters->toArray()]);

    // Obtener el video si existe
    $video = $producto->media->where('video_link', '!=', null)->first();
    $producto->video_link = $video ? $video->video_link : null;

    // Obtener las imágenes
    $producto->imagenes = $producto->media->where('image_path', '!=', null)->map(function ($media) {
        return asset('images/' . $media->image_path);
    })->all();
    $producto->image_ids = $producto->media->where('image_path', '!=', null)->pluck('id')->all();

    // Obtener los filtros únicos
    $producto->filters = $producto->productFilters->pluck('filter')->unique()->values()->toArray();
    \Log::info('Filtros procesados:', ['filters_final' => $producto->filters]);

    // **CORRECCIÓN: Pasar los filtros a la respuesta JSON**
    return response()->json($producto);
}

/**
 * Show the form for creating a new resource.
 */
public function create()
{
    //
}
public function updateOrder(Request $request)
{
    try {
        // Actualizar el orden
        foreach ($request->input('order') as $order => $id) {
            Producto::where('id', $id)->update(['order' => $order]);
        }

        // Devolver todos los productos ordenados
        $productos = Producto::with('media')->orderBy('order', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizado correctamente',
            'productos' => $productos
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el orden'
        ], 500);
    }
}
/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
try {
    Log::info('Datos de la solicitud:', $request->all());

    $request->validate([
        'titulo' => 'required',
        'descripcion' => 'required',
        'imagenes.*' => 'nullable|image',
        'video' => 'nullable|url',
        'filter' => 'required|array',
    ]);

    $producto = new Producto;
    $producto->titulo = $request->titulo;
    $producto->descripcion = $request->descripcion;
    $producto->destacado = $request->has('destacado');
    $producto->codigo = $request->codigo;
    $producto->configuraciones = $request->configuraciones;
    $producto->save();

    // Guardar los filtros
    if ($request->has('filter')) {
        foreach ($request->filter as $filter) {
            if (!empty($filter)) {
                $parentFilter = $this->getParentFilter($filter);
                Log::info('Creando filtro:', ['filter' => $filter, 'parent' => $parentFilter]);
                $producto->productFilters()->create([
                    'filter' => $filter,
                    'parent_filter' => $parentFilter,
                ]);
            }
        }
    }

    // Crear un nuevo modelo Media
    $media = new Media;
    $media->product_id = $producto->id;

    // Guardar las imágenes
    if ($request->hasFile('imagenes')) {
        $imagenes = $request->file('imagenes');

        // Si $imagenes no es un array, conviértelo en un array con un solo elemento
        if (!is_array($imagenes)) {
            $imagenes = [$imagenes];
        }

        Log::info('Número de imágenes cargadas:', ['count' => count($imagenes)]);

        foreach ($imagenes as $index => $imagen) {
            $imageName = time() . '_' . $index . '.' . $imagen->getClientOriginalExtension();
            $filePath = base_path('public_html/images/' . $imageName);  // Usar base_path()
            Log::info('Ruta del archivo de imagen: ' . $filePath);

            // Mover la imagen al directorio correcto
            $imagen->move(base_path('public_html/images'), $imageName);

            $media->image_path = $imageName;  // Guarda solo el nombre del archivo

            Log::info('Imagen guardada:', ['image_path' => $imageName]);
        }
    }

    // Guardar el video
    if ($request->video) {
        Log::info('URL del video: ' . $request->video);
        // Parsea la URL del video para extraer el ID
        parse_str(parse_url($request->video, PHP_URL_QUERY), $my_array_of_vars);
        $videoId = $my_array_of_vars['v'] ?? null;  // Obtén el ID del video
        Log::info('ID del video: ' . $videoId);

        $media->video_link = $videoId;  // Guarda el ID del video
        Log::info('Video guardado:', ['video_link' => $videoId]);
    }

    $media->save();
    Log::info('Media guardado:', ['media' => $media]);

    return redirect()->route('admin.index'); // Redirige a /admin
} catch (\Exception $e) {
    Log::error('Error al guardar el producto:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

    return redirect()->route('admin.index')->with('error', 'Hubo un error al agregar el producto.');
}
}

/**
 * Show the form for editing the specified resource.
 */
public function update(Request $request, $id)
{
    try {
        Log::info('Datos recibidos:', $request->all());

        $producto = Producto::findOrFail($id);

        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'imagenes.*' => 'nullable|image',
            'video' => 'nullable|string',
            'filter' => 'nullable|array',
            'filter.*' => 'string',
            'configuraciones' => 'nullable|string'  // Agregamos validación para configuraciones
        ]);

        // Actualizar campos básicos
        $producto->titulo = $request->titulo;
        $producto->descripcion = $request->descripcion;
        $producto->destacado = $request->input('destacado', 0);
        $producto->codigo = $request->codigo;

        // Manejar configuraciones
        if ($request->has('configuraciones')) {
            // Las configuraciones vienen como string separado por guiones
            $producto->configuraciones = $request->configuraciones;
        } else {
            $producto->configuraciones = null;
        }

        $producto->save();

        // Eliminar los filtros existentes
        $producto->productFilters()->delete();

        if ($request->has('filter') && is_array($request->filter)) {
            foreach ($request->filter as $filter) {
                if (!empty($filter)) {
                    $parentFilter = $this->getParentFilter($filter);
                    Log::info('Creando filtro:', ['filter' => $filter, 'parent' => $parentFilter]);
                    $producto->productFilters()->create([
                        'filter' => $filter,
                        'parent_filter' => $parentFilter
                    ]);
                }
            }
        }

        // Guardar las nuevas imágenes
        for ($i = 1; $i <= 4; $i++) {
            if ($request->hasFile("imagenes.{$i}")) {
                $imagen = $request->file("imagenes.{$i}");
                $imageName = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(base_path('public_html/images'), $imageName);

                $media = new Media;
                $media->product_id = $producto->id;
                $media->image_path = $imageName;
                $media->save();
            }
        }

        // Guardar el nuevo video
        if ($request->video) {
            // Eliminar el video antiguo
            $oldVideo = $producto->media()->whereNotNull('video_link')->first();
            if ($oldVideo) {
                $oldVideo->delete();
            }

            $media = new Media;
            $media->product_id = $producto->id;
            $media->video_link = $request->video;
            $media->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente'
        ]);
    } catch (\Exception $e) {
        Log::error('Error en actualización:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el producto: ' . $e->getMessage()
        ], 500);
    }
}


public function destroy(Producto $producto)
{
// Eliminar medios asociados
foreach ($producto->media as $media) {
    if ($media->image_path) {
        $filePath = base_path('public_html/images/' . $media->image_path); // Ruta correcta
        if (file_exists($filePath)) {
            try {
                unlink($filePath);
            } catch (\Exception $e) {
                Log::error('Error al eliminar la imagen: ' . $e->getMessage());
                // Puedes optar por continuar incluso si no se puede eliminar la imagen
            }
        } else {
            Log::warning('El archivo no existe: ' . $filePath);
        }
    }
    $media->delete();
}

// Eliminar el producto de la base de datos
$producto->delete();

return redirect()->route('admin.productos.index');
}

public function filtrarProductos(Request $request)
{
    try {
        Log::info('Iniciando filtrarProductos', [
            'request_data' => $request->all(),
            'has_filter' => $request->has('filter'),
            'is_ajax' => $request->ajax()
        ]);

        $query = Producto::with(['media', 'filters']);

        if ($request->has('filter')) {
            $filters = $request->filter;
            $query->whereHas('filters', function ($q) use ($filters) {
                $q->whereIn('filter', $filters)
                    ->orWhereIn('parent_filter', $filters);
            });
        }

        // Siempre usar paginación excepto cuando se está ordenando
        if ($request->has('sorting')) {
            $productos = $query->orderBy('order', 'asc')->get();
            Log::info('Productos sin paginar', ['count' => $productos->count()]);
        } else {
            $productos = $query->orderBy('order', 'asc')->paginate(12)->withQueryString();
            Log::info('Productos paginados', [
                'total' => $productos->total(),
                'por_página' => $productos->perPage(),
                'página_actual' => $productos->currentPage()
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.productos_filtrados', [
                    'productos' => $productos,
                    'ordenando' => $request->has('sorting')
                ])->render(),
                'pagination' => $request->has('sorting') ? '' : $productos->links()->toHtml()
            ]);
        }

        return view('admin.productos_filtrados', [
            'productos' => $productos,
            'ordenando' => $request->has('sorting')
        ]);

    } catch (\Exception $e) {
        Log::error('Error en filtrarProductos:', [
            'mensaje' => $e->getMessage(),
            'linea' => $e->getLine(),
            'archivo' => $e->getFile()
        ]);
        
        if ($request->ajax()) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        throw $e;
    }
}

public function deleteImage($id)
{
    try {
        $media = Media::findOrFail($id);

        // Eliminar la imagen del sistema de archivos
        if ($media->image_path && file_exists(base_path('public_html/images/' . $media->image_path))) {
            unlink(base_path('public_html/images/' . $media->image_path));
        }

        $media->delete();

        return response()->json(['status' => 'success', 'message' => 'Imagen eliminada correctamente']);
    } catch (\Exception $e) {
        Log::error('Error al eliminar la imagen: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Error al eliminar la imagen'], 500);
    }
}

public function reorder(Request $request)
{
    try {
        if (!$request->has('order')) {
            return response()->json(['success' => false, 'message' => 'No order data provided'], 400);
        }

        foreach ($request->order as $item) {
            $producto = Producto::find($item['id']);
            if ($producto) {
                $producto->order = $item['order'];
                $producto->save();
            }
        }

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Error reordering products: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error'], 500);
    }
}

public function getAllProducts(Request $request)
{
    try {
        if (!$request->ajax()) {
            abort(404);
        }

        $productos = Producto::orderBy('order', 'asc')->get(['id', 'titulo']);

        return response()->json([
            'success' => true,
            'productos' => $productos
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

private function getParentFilter($filter)
{
    $filterMap = [
        'Lamparas Electronica' => 'Automotor',
        'Medidores de bateria' => 'Automotor',
        'Luminaria' => 'Luminarias',
        'Portatil' => 'Luminarias',
        'Reflectores' => 'Luminarias',
        'Balizas' => 'Autoelevadores',
        'Seguridad' => 'Autoelevadores',
        'iluminacion' => 'Energias Alternativas',
        'reguladores' => 'Energias Alternativas',
        'Solar' => 'Energias Alternativas'
    ];

    return $filterMap[$filter] ?? null;
}
}