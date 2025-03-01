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
            'filter' => 'required|array'
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
                    $producto->filters()->create([
                        'filter' => $filter,
                        'parent_filter' => $parentFilter
                    ]);
                }
            }
        }

        if ($request->hasFile('imagenes')) {
            $imagenes = $request->file('imagenes');

            // Si $imagenes no es un array, conviértelo en un array con un solo elemento
            if (!is_array($imagenes)) {
                $imagenes = [$imagenes];
            }

            Log::info('Número de imágenes cargadas:', ['count' => count($imagenes)]);

            foreach ($imagenes as $index => $imagen) {
                $imageName = time() . '_' . $index . '.' . $imagen->getClientOriginalExtension();
                $imagen->move(base_path('public_html/images'), $imageName);

                $media = new Media;
                $media->product_id = $producto->id;
                $media->image_path = $imageName;
                $media->save();

                Log::info('Imagen guardada:', ['image_path' => $imageName]);
            }
        }

        if ($request->video) {
            parse_str(parse_url($request->video, PHP_URL_QUERY), $my_array_of_vars);
            $videoId = $my_array_of_vars['v'];  // Aquí se obtiene el ID del video

            $media = new Media;
            $media->product_id = $producto->id;
            $media->video_link = $videoId;  // Aquí se guarda el ID del video en lugar de la URL completa
            $media->save();
        }

        return redirect()->route('admin');
    } catch (\Exception $e) {
        Log::error('Error al guardar el producto:', ['error' => $e->getMessage()]);
        return redirect()->route('admin')->with('error', 'Hubo un error al agregar el producto.');
    }
}

/**
 * Show the form for editing the specified resource.
 */
public function edit($id)
{
\Log::info('Iniciando getProductData para producto ID: ' . $id);
\Log::info('Ubicación del archivo AdminController.php:', [realpath(__FILE__)]);
\Log::info('Contenido del archivo AdminController.php:', [file_get_contents(__FILE__)]);

$producto = Producto::with('media', 'filters')->findOrFail($id);
\Log::info('Relaciones cargadas. Filters:', ['filters_raw' => $producto->filters->toArray()]);

// Obtener el video si existe
$video = $producto->media->where('video_link', '!=', null)->first();
$video_link = $video ? $video->video_link : null;

// Obtener las imágenes
$imagenes = $producto->media->where('image_path', '!=', null)->pluck('image_path')->all();
$image_ids = $producto->media->where('image_path', '!=', null)->pluck('id')->all();

// Obtener los filtros únicos
$filters = $producto->filters->pluck('filter')->unique()->values()->toArray();
\Log::info('Filtros procesados:', ['filters_final' => $filters]);

$data = [
    'id' => $producto->id,
    'titulo' => $producto->titulo,
    'descripcion' => $producto->descripcion,
    'codigo' => $producto->codigo,
    'video_link' => $video_link,
    'media' => $producto->media,
    'configuraciones' => $producto->configuraciones,
    'filters' => $filters, // Usa los filtros únicos
    'destacado' => $producto->destacado,
    'imagenes' => $imagenes,
    'image_ids' => $image_ids
];

\Log::info('Datos a enviar al frontend:', $data);
return response()->json($data);
}
/**
 * Update the specified resource in storage.
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

        $producto->filter = $request->filter;
        $producto->save();

        if ($request->has('filter') && is_array($request->filter)) {
            foreach ($request->filter as $filter) {
                if (!empty($filter)) {
                    $parentFilter = $this->getParentFilter($filter);
                    Log::info('Creando filtro:', ['filter' => $filter, 'parent' => $parentFilter]);
                    $producto->filters()->create([
                        'filter' => $filter,
                        'parent_filter' => $parentFilter
                    ]);
                }
            }
        }

        // Obtén los IDs de las imágenes existentes desde el modelo $producto
        $existing_image_ids = $producto->media()->whereNotNull('image_path')->pluck('id')->toArray();
        Log::info('IDs de imágenes existentes:', $existing_image_ids);

        // Guardar las nuevas imágenes
        if ($request->hasFile('imagenes')) {
            $imagenes = $request->file('imagenes');

            foreach ($imagenes as $imagen) {
                $imageName = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(base_path('public_html/images'), $imageName);

                $media = new Media;
                $media->product_id = $producto->id;
                $media->image_path = $imageName;
                $media->save();
            }
        }

        // Combinar los IDs de las imágenes existentes con los IDs de las nuevas imágenes
        $new_image_ids = $producto->media()->whereNotNull('image_path')->pluck('id')->toArray();
        $image_ids_to_keep = array_merge($existing_image_ids, $new_image_ids);

        // Eliminar las imágenes que no están en la lista combinada de imágenes existentes y nuevas
        foreach ($producto->media()->whereNotNull('image_path')->get() as $image) {
            if (!in_array($image->id, $image_ids_to_keep)) {
                if (file_exists(public_path('images/' . $image->image_path))) {
                    unlink(public_path('images/' . $image->image_path));
                }
                $image->delete();
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
/**
 * Remove the specified resource from storage.
 */
public function destroy(Producto $producto)
{
    // Eliminar medios asociados
    foreach ($producto->media as $media) {
        if ($media->image_path) {
            unlink(public_path('images/' . $media->image_path));
        }
        $media->delete();
    }

    // Eliminar el producto de la base de datos
    $producto->delete();

    return redirect()->route('admin');
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

// En ProductoController.php
public function deleteImage($id)
{
    $media = Media::findOrFail($id);
    if ($media->image_path && file_exists(base_path('public_html/images/' . $media->image_path))) {
        unlink(base_path('public_html/images/' . $media->image_path));
    }
    $media->delete();

    return response()->json(['status' => 'success']);
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