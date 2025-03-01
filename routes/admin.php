<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', [AdminController::class, 'index'])->name('admin.index');

// Rutas de productos en admin
Route::get('/productos', [AdminController::class, 'index'])->name('admin.productos.index');
Route::get('/productos/create', [AdminController::class, 'create'])->name('admin.productos.create');
Route::post('/productos', [AdminController::class, 'store'])->name('admin.productos.store');
Route::get('/productos/{producto}/edit', [AdminController::class, 'edit'])->name('admin.productos.edit');
Route::put('/productos/{producto}', [AdminController::class, 'update'])->name('admin.productos.update');
Route::delete('/productos/{producto}', [AdminController::class, 'destroy'])->name('admin.productos.destroy');

// Rutas adicionales para productos
Route::post('/productos/reorder', [AdminController::class, 'reorder'])->name('admin.productos.reorder');
Route::delete('/productos/delete-image/{id}', [AdminController::class, 'deleteImage'])->name('admin.productos.deleteImage');

Route::get('/filtrar', [AdminController::class, 'filtrarProductos'])->name('admin.filtrar');
Route::get('/getProductData/{producto}', [AdminController::class, 'getProductData'])->name('admin.getProductData');