<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [ProductoController::class, 'showProductos'])->name('productos.index');
Route::get('/producto/{producto}', [ProductoController::class, 'show'])->name('producto.detalle');

// Rutas estáticas (agregar los names)
Route::get('/quienes-somos', function () {
return view('quienesSomos');
})->name('quienes-somos');

Route::get('/autoelevadores', function () {
return view('autoelevadores');
})->name('autoelevadores');

Route::get('/redComercializacion', function () {
return view('redComercializacion');
})->name('redComercializacion');

// Rutas de contacto
Route::get('/contacto', function () {
return view('contacto');
})->name('contacto');

Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');

// Rutas de autenticación
Auth::routes(['register' => false]);

// Rutas protegidas por autenticación (ADMIN)
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
require __DIR__.'/admin.php';
});