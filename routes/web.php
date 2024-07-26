<?php
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HomeController;

// ... otras rutas ...

// Rutas públicas del buscador y filtro (EXCLUIDAS DE 'AUTH')
Route::get('/admin/productos/filtrar', [ProductoController::class, 'adminIndex'])->name('admin.productos.filtrar');
Route::get('/search', [ProductosController::class, 'search'])->name('search'); // Asumiendo que 'ProductosController' es el controlador correcto

// Rutas protegidas por autenticación
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::resource('admin/productos', ProductoController::class);
    // ... otras rutas que requieren autenticación ...
});

Route::get('/quienes-somos', function () {
    return view('quienesSomos');
});
Route::get('/redComercializacion', function () {
    return view('redComercializacion');
});
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::delete('/admin/productos/delete-image/{id}', [ProductoController::class, 'deleteImage']);
Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');
Route::get('admin/productos/{producto}/data', [ProductoController::class, 'getProductData'])->name('productos.data');
Route::get('/productos/{productId?}', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/all', [ProductoController::class, 'all'])->name('productos.all');
Route::get('/productos', [ProductoController::class, 'showProductos']);
Route::get('/', [HomeController::class, 'index']);

Route::post('/contacto', [App\Http\Controllers\ContactoController::class, 'enviar'])->name('contacto.enviar');

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');