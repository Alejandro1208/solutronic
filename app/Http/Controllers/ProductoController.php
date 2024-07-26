<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;
use App\Models\Media;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $productId = null)
    {
        $search = $request->get('search');
        $filter = $request->get('filter');
    
        if ($search) {
            $productos = Producto::where('titulo', 'like', "%$search%");
        } elseif ($filter) {
            $productos = Producto::where('filter', $filter);
        } else {
            $productos = Producto::query();
        }
    
        $productos = $productos->get();
        $productos->load('media');
    
        if ($request->ajax()) {
            return view('buscador', compact('productos'))->render();
        } else {
            return view('productos', compact('productos', 'productId'));
        }
    }
public function getProductData(Producto $producto)
{
    
    $producto->load('media');
    $video = $producto->media->where('video_link', '!=', null)->first();
    $producto->video_link = $video ? '' . $video->video_link : null;
    $producto->imagenes = $producto->media->where('image_path', '!=', null)->pluck('image_path')->all();
    $producto->image_ids = $producto->media->where('image_path', '!=', null)->pluck('id')->all(); // Agrega esta línea
    Log::info('Datos del producto:', ['producto' => $producto]);
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
        foreach ($request->input('order') as $order => $id) {
            Producto::where('id', $id)->update(['order' => $order]);
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
            'video' => 'nullable|url'
        ]);

        $producto = new Producto;
        $producto->titulo = $request->titulo;
        $producto->descripcion = $request->descripcion;
        $producto->destacado = $request->has('destacado');
        $producto->filter = $request->input('filter');  //
        $producto->codigo = $request->codigo; 
        $producto->configuraciones = $request->configuraciones;

        $producto->save();

        if ($request->hasFile('imagenes')) {
            $imagenes = $request->file('imagenes');

            // Si $imagenes no es un array, conviértelo en un array con un solo elemento
            if (!is_array($imagenes)) {
                $imagenes = [$imagenes];
            }

            Log::info('Número de imágenes cargadas:', ['count' => count($imagenes)]);

            foreach ($imagenes as $index => $imagen) {
                $imageName = time() . '_' . $index . '.' . $imagen->getClientOriginalExtension();
                $imagen->move(public_path('images'), $imageName);
        
                $media = new Media;
                $media->product_id = $producto->id;
                $media->image_path = $imageName;
                $media->save();
        
                Log::info('Imagen guardada:', ['image_path' => $imageName]);
            }
        }

        if ($request->video) {
            parse_str( parse_url( $request->video, PHP_URL_QUERY ), $my_array_of_vars );
            $videoId = $my_array_of_vars['v'];  // Aquí se obtiene el ID del video

            $media = new Media;
            $media->product_id = $producto->id;
            $media->video_link = $videoId;  // Aquí se guarda el ID del video en lugar de la URL completa
            $media->save();
        }

        return redirect()->route('admin');
    }catch (\Exception $e) {
        Log::error('Error al guardar el producto:', ['error' => $e->getMessage()]);
        return redirect()->route('admin')->with('error', 'Hubo un error al agregar el producto.');
    }
}

public function all()
{
    $productos = Producto::with('media')->get();
    return view('product_list', compact('productos'));
}
    /**
     * Display the specified resource.
     */
    public function showProductos()
    {
        $productos = Producto::all();
        return view('productos', compact('productos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('edit', compact('producto'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
    
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'imagenes.*' => 'nullable|image',
            'video' => 'nullable|string',
        ]);
    
        Log::info('Valor de destacado recibido:', ['destacado' => $request->input('destacado')]);
    
        // Actualizar los campos del producto
        $producto->titulo = $request->titulo;
        $producto->descripcion = $request->descripcion;
        $producto->destacado = $request->input('destacado', 0);
        $producto->filter = $request->input('filter');
        $producto->codigo = $request->codigo;
        $producto->configuraciones = $request->configuraciones;
        $producto->save();
    
        // Obtén los IDs de las imágenes existentes desde el modelo $producto
        $existing_image_ids = $producto->media()->whereNotNull('image_path')->pluck('id')->toArray();
        Log::info('IDs de imágenes existentes:', $existing_image_ids);
    
        // Guardar las nuevas imágenes
        if ($request->hasFile('imagenes')) {
            $imagenes = $request->file('imagenes');
    
            foreach ($imagenes as $imagen) {
                $imageName = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('images'), $imageName);
    
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
    
        return redirect()->route('admin')->with('success', 'Producto actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Eliminar la imagen del producto
        foreach ($producto->media as $media) {
            if ($media->image_path && file_exists(public_path('images/' . $media->image_path))) {
                unlink(public_path('images/' . $media->image_path));
            }
            $media->delete();
        }
    
        // Eliminar el producto de la base de datos
        $producto->delete();
    
        return redirect()->route('admin');
    }
    public function search(Request $request)
    {
        Log::info('Datos de la solicitud:', $request->all()); // Agrega esta línea para registrar la solicitud
    
        $query = $request->input('query');
        $filter = $request->input('filter');
    
        $productos = Producto::query();
    
        if ($query) {
            $productos->where(function ($q) use ($query) {
                $q->where('titulo', 'LIKE', "%$query%")
                  ->orWhere('descripcion', 'LIKE', "%$query%");
            });
        }
    
        if ($filter && $filter !== 'Mostrar todos') {
            $productos->where('filter', 'LIKE', "%$filter%");
        }
    
        try { // Agrega un bloque try-catch para capturar errores
            $productos = $productos->get();
            $productos->load('media');
        } catch (\Exception $e) {
            Log::error('Error al realizar la búsqueda:', ['error' => $e->getMessage()]); // Registra el error
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error al realizar la búsqueda.'
            ], 500); // Devuelve una respuesta JSON con un mensaje de error
        }
    
        if ($request->ajax()) {
            return response()->json([
                'data' => $productos,
                'status' => 'success'
            ]);
        }
    
        return redirect()->route('admin');
    }
    public function adminIndex(Request $request)
    {
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            if ($filter === 'Mostrar todos') {
                $productos = Producto::paginate(10); // Cambio aquí
            } else {
                $productos = Producto::where('filter', 'LIKE', '%' . $filter . '%')->paginate(10); // Y aquí
            }
        } else {
            $productos = Producto::paginate(10); // Y también aquí
        }
    
        $productos->load('media');
    
        return view('admin', compact('productos'));
    }
    // En ProductoController.php
public function deleteImage($id)
{
    $media = Media::findOrFail($id);
    if ($media->image_path && file_exists(public_path('images/' . $media->image_path))) {
        unlink(public_path('images/' . $media->image_path));
    }
    $media->delete();

    return response()->json(['status' => 'success']);
}
}
