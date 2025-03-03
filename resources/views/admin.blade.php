<!DOCTYPE html>
@php
$ordenando = $ordenando ?? false;
@endphp
@extends('layouts.app')
@section('content')
<div class="container contenido my-5">
    @if (Auth::check())
        <h1 class="mb-4 text-center">Panel de Administración</h1>
        <button type="button" class="btn btn-primary" id="btnAgregarProducto">
            Agregar Producto
        </button>
        <hr>
        <h2 class="my-4 text-center">Productos Existentes</h2>
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar productos..."
                style="max-width: 500px; margin: 0 auto;">
        </div>
        <button id="toggleSortOrder" class="btn btn-primary mb-2">Ordenar Productos</button>
        <!-- Contenedor de tarjetas -->
        <div class="row g-4" id="product-list">
            @foreach ($productos->sortBy('order') as $producto)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm product-card" data-id="{{ $producto->id }}"
                        data-order="{{ $producto->order }}">
                        <!-- Modificación del carousel -->
                        <div id="carousel{{ $producto->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($producto->media as $index => $media)
                                    @if ($media->image_path)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="card-img-container" style="height: 250px; overflow: hidden;">
                                                <img src="{{ asset('images/' . $media->image_path) }}"
                                                    class="d-block w-100 h-100" style="object-fit: contain;"
                                                    alt="{{ $producto->titulo }}">
                                            </div>
                                        </div>
                                    @endif
                                    @if ($media->video_link)
                                        <div
                                            class="carousel-item {{ !$media->image_path && $index === 0 ? 'active' : '' }}">
                                            <div class="card-img-container" style="height: 250px;">
                                                <iframe class="w-100 h-100"
                                                    src="https://www.youtube.com/embed/{{ $media->video_link }}"
                                                    frameborder="0" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @if ($producto->media->count() > 1)
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carousel{{ $producto->id }}" data-bs-slide="prev">
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carousel{{ $producto->id }}" data-bs-slide="next">
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                        <!-- Resto del contenido de la card -->
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->titulo }}</h5>
                            <p class="card-text">{{ $producto->descripcion }}</p>
                            <p>Código: {{ $producto->codigo }}</p>
                            <p>Configuraciones: {{ $producto->configuraciones }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div class="d-flex" style="height: 54px">
                                    <button type="button"
                                        class="btn btn-primary m-2 edit-button pb-1 justify-content-center align-content-center"
                                        data-id="{{ $producto->id }}">Editar</button>
                                    <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger m-2">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Lista para ordenar -->
        <ul id="sortableList" style="display: none;">
            @foreach (App\Models\Producto::orderBy('order', 'asc')->get() as $producto)
                <li data-id="{{ $producto->id }}" data-order="{{ $producto->order }}">
                    {{ $producto->titulo }}
                </li>
            @endforeach
        </ul>

        <!-- Paginacion -->
        <div class="pagination-container d-flex justify-content-center mt-5">
            @if (!$ordenando && !request()->has('showAll'))
                <div class="d-flex justify-content-center mt-5">
                    {{ $productos->links() }}
                </div>
            @endif
        </div>
    @else
        <p class="text-center">Debe iniciar sesión para acceder al panel de administración.</p>
    @endif
</div>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!-- Modal editar -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="product-id" name="id">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo">
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                </div>
                <div class="mb-3">
<div class="mb-3">
<label for="imagen1" class="form-label">Imagen 1:</label>
<input type="file" class="form-control" id="imagen1" name="imagenes[]">
<img id="editpreview1" src="{{ isset($producto->media[0]) ? asset('images/' . $producto->media[0]->image_path) : '#' }}" alt="Agregar Imagen" style="max-width: 200px; max-height: 200px; object-fit: contain;"/>
<button class="btn btn-danger delete-image" data-id="{{ isset($producto->media[0]) ? $producto->media[0]->id : '' }}">Eliminar</button>
</div>
<div class="mb-3">
<label for="imagen2" class="form-label">Imagen 2:</label>
<input type="file" class="form-control" id="imagen2" name="imagenes[]">
<img id="editpreview2" src="{{ isset($producto->media[1]) ? asset('images/' . $producto->media[1]->image_path) : '#' }}" alt="Agregar Imagen"  style="max-width: 200px; max-height: 200px; object-fit: contain;"/>
<button class="btn btn-danger delete-image" data-id="{{ isset($producto->media[1]) ? $producto->media[1]->id : '' }}">Eliminar</button>
</div>
<div class="mb-3">
<label for="imagen3" class="form-label">Imagen 3:</label>
<input type="file" class="form-control" id="imagen3" name="imagenes[]">
<img id="editpreview3" src="{{ isset($producto->media[2]) ? asset('images/' . $producto->media[2]->image_path) : '#' }}" alt="Agregar Imagen" style="max-width: 200px; max-height: 200px; object-fit: contain;"/>
<button class="btn btn-danger delete-image" data-id="{{ isset($producto->media[2]) ? $producto->media[2]->id : '' }}">Eliminar</button>
</div>
<div class="mb-3">
<label for="imagen4" class="form-label">Imagen 4:</label>
<input type="file" class="form-control" id="imagen4" name="imagenes[]">
<img id="editpreview4" src="{{ isset($producto->media[3]) ? asset('images/' . $producto->media[3]->image_path) : '#' }}" alt="Agregar Imagen" style="max-width: 200px; max-height: 200px; object-fit: contain;"/>
<button class="btn btn-danger delete-image" data-id="{{ isset($producto->media[3]) ? $producto->media[3]->id : '' }}">Eliminar</button>
</div>
                    <!-- Aquí irán los demás campos de entrada -->
                    <div class="mb-3">
                        <label for="video" class="form-label">Video:</label>
                        <input type="text" class="form-control" id="video" name="video">
                    </div>
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código:</label>
                        <input type="text" class="form-control" id="codigo" name="codigo">
                    </div>
<div class="mb-3">
<label for="configuraciones" class="form-label">Configuraciones:</label>
<div style="position: relative;">  <!-- Añadimos este div -->
<textarea class="form-control" id="configuraciones" name="configuraciones"></textarea>
</div>
</div>
                    <div class="mb-3">
                        <label for="edit_filter" class="form-label">Filtros:</label>
                        <select name="filter[]" id="edit_filter" class="form-control select2-multiple"
                            multiple="multiple">
                            <option value="Automotor" data-parent="true">Automotor</option>
                            <option value="Lamparas Electronica" data-category="Automotor">Lámparas Electrónica
                            </option>
                            <option value="Medidores de bateria" data-category="Automotor">Medidores de batería
                            </option>

                            <option value="Luminarias" data-parent="true">Luminarias</option>
                            <option value="Luminaria" data-category="Luminarias">Luminaria</option>
                            <option value="Portatil" data-category="Luminarias">Portátil</option>
                            <option value="Reflectores" data-category="Luminarias">Reflectores</option>

                            <option value="Autoelevadores" data-parent="true">Autoelevadores</option>
                            <option value="Balizas" data-category="Autoelevadores">Balizas</option>
                            <option value="Seguridad" data-category="Autoelevadores">Seguridad</option>

                            <option value="Energias Alternativas" data-parent="true">Energías Alternativas
                            </option>
                            <option value="iluminacion" data-category="Energias Alternativas">Iluminación</option>
                            <option value="reguladores" data-category="Energias Alternativas">Reguladores</option>
                            <option value="Solar" data-category="Energias Alternativas">Solar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="destacado">Destacado:</label>
                        <select class="form-control" id="destacado" name="destacado">
                            <option value="0"
                                {{ old('destacado', $producto->destacado) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1"
                                {{ old('destacado', $producto->destacado) == 1 ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
        </form>
    </div>
</div>
</div>
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<!-- fin Modal editar -->
@endsection
<!-- Modal Agregar Producto -->
<div class="modal fade" id="addProductModal" aria-labelledby="addProductModalLabel" aria-hidden="true"
style="z-index: 99999;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProductModalLabel">Agregar Nuevo Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo"
                        value="{{ old('titulo') }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen1" class="form-label">Imagen 1:</label>
                    <input type="file" class="form-control" id="imagen1" name="imagenes[]">
                </div>
                <div class="mb-3">
                    <label for="imagen2" class="form-label">Imagen 2:</label>
                    <input type="file" class="form-control" id="imagen2" name="imagenes[]">
                </div>
                <div class="mb-3">
                    <label for="imagen3" class="form-label">Imagen 3:</label>
                    <input type="file" class="form-control" id="imagen3" name="imagenes[]">
                </div>
                <div class="mb-3">
                    <label for="imagen4" class="form-label">Imagen 4:</label>
                    <input type="file" class="form-control" id="imagen4" name="imagenes[]">
                </div>
                <div class="mb-3">
                    <label for="video" class="form-label">Video:</label>
                    <input type="text" class="form-control" id="video" name="video"
                        value="{{ old('video') }}">
                </div>
                <div class="mb-3">
                    <label for="add_filter" class="form-label">Filtros:</label>
                    <select name="filter[]" id="add_filter" class="form-control select2-multiple"
                        multiple="multiple">
                        <option value="Automotor" data-parent="true">Automotor</option>
                        <option value="Lamparas Electronica" data-category="Automotor">Lámparas Electrónica
                        </option>
                        <option value="Medidores de bateria" data-category="Automotor">Medidores de batería
                        </option>

                        <option value="Luminarias" data-parent="true">Luminarias</option>
                        <option value="Luminaria" data-category="Luminarias">Luminaria</option>
                        <option value="Portatil" data-category="Luminarias">Portátil</option>
                        <option value="Reflectores" data-category="Luminarias">Reflectores</option>

                        <option value="Autoelevadores" data-parent="true">Autoelevadores</option>
                        <option value="Balizas" data-category="Autoelevadores">Balizas</option>
                        <option value="Seguridad" data-category="Autoelevadores">Seguridad</option>

                        <option value="Energias Alternativas" data-parent="true">Energías Alternativas</option>
                        <option value="iluminacion" data-category="Energias Alternativas">Iluminación</option>
                        <option value="reguladores" data-category="Energias Alternativas">Reguladores</option>
                        <option value="Solar" data-category="Energias Alternativas">Solar</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo"
                        value="{{ old('codigo') }}">
                </div>
<div class="mb-3">
<label for="configuraciones" class="form-label">Configuraciones:</label>
<textarea class="form-control" id="configuraciones" name="configuraciones"></textarea>
</div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="destacado" id="destacado">
                    <label class="form-check-label" for="destacado">
                        Destacado
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Agregar Producto</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- Fin Modal Agregar Producto -->

<head>
<!-- jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Luego Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Sortable JS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

@yield('styles')
</head>
@section('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
console.log("Script cargado");

// Función para inicializar CKEditor 5
function initCKEditor(selector) {
    ClassicEditor
        .create(document.querySelector(selector))
        .then(editor => {
            console.log('CKEditor is ready:', editor);
            // Guardar la instancia del editor para poder destruirla luego
            window.ckeditors = window.ckeditors || {};
            window.ckeditors[selector] = editor;
        })
        .catch(error => {
            console.error('There was a problem initializing CKEditor:', error);
        });
}

// Función para destruir CKEditor 5
function destroyCKEditor(selector) {
    if (window.ckeditors && window.ckeditors[selector]) {
        window.ckeditors[selector].destroy()
            .then(() => {
                console.log('CKEditor destroyed');
                delete window.ckeditors[selector];
            })
            .catch(error => {
                console.error('Error destroying CKEditor:', error);
            });
    }
}

// Buscador en vivo
$('#searchInput').on('input', function() {
    const searchTerm = $(this).val().toLowerCase();

    if (searchTerm === '') {
        window.location.reload();
        return;
    }

    $.ajax({
        url: window.location.pathname,
        method: 'GET',
        data: {
            search: searchTerm
        },
        success: function(response) {
            $('#product-list').html(response);
            $('.pagination-container').hide();
        },
        error: function(xhr, status, error) {
            console.error('Error en la búsqueda:', {
                status: status,
                error: error,
                response: xhr.responseText
            });
        }
    });
});

// ==================== INICIALIZACIÓN DE SELECT2 ====================
$('#filter-form #filter').select2({
    placeholder: 'Selecciona filtros',
    allowClear: true,
    dropdownParent: $('body'),
    width: '100%'
});

// ==================== MANEJO DE MODALES ====================
var myModal = null; // Declarar la variable myModal fuera del evento click

$('#btnAgregarProducto').on('click', function() {
    console.log("Se hizo clic en el botón 'Agregar Producto'");

    // Usar Vue.nextTick(function() {
        // Inicializar el modal dentro de nextTick
        myModal = new bootstrap.Modal(document.getElementById('addProductModal'));
        myModal.show();
        console.log("Se intentó mostrar el modal");
});

$('#addProductModal form').on('submit', function(e) {
    e.preventDefault();
    console.log("Se envió el formulario de agregar producto");

    var formData = new FormData(this);

    $.ajax({
        url: "/admin/productos",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            // Actualizar la lista de productos con el HTML recibido
            $('#product-list').html(response.html);
            $('.pagination-container').html(response.pagination);

            // Cerrar el modal y limpiar el formulario
            $('#addProductModal').modal('hide');
            $('#addProductModal form')[0].reset();

            // Mostrar mensaje de éxito
            alert('Producto agregado exitosamente');
        },
        error: function(xhr) {
            console.error('Error en la petición AJAX:', xhr.responseText);
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.errors) {
                    var errorMessages = Object.values(response.errors).join('\n');
                    alert(errorMessages);
                } else {
                    alert('Error al agregar el producto.');
                }
            } catch (e) {
                alert('Error al agregar el producto.');
            }
        }
    });
});

// --- Modal Editar Producto ---
$(document).on('click', '.edit-button', function(e) {
    e.preventDefault();
    var productId = $(this).data('id');
    console.log("ID del producto a editar:", productId);

    $.ajax({
        url: `/admin/getProductData/${productId}`,
        method: 'GET',
        success: function(response) {
            console.log("Datos del producto recibidos:", response);

            $('#editForm').attr('action', `/admin/productos/${productId}`);
            $('#product-id').val(response.id);
            $('#editModal #titulo').val(response.titulo);
            $('#editModal #descripcion').val(response.descripcion);
            $('#editModal #codigo').val(response.codigo);
            $('#editModal #video').val(response.video_link);
            $('#editModal #configuraciones').val(response.configuraciones); // Establecer el valor en el textarea

            // Manejar imágenes
            $('#editModal [id^=editpreview]').attr('src', '#').hide();
            $('#editModal input[name="existing_image_ids[]"]').val('');

            if (response.media && response.media.length > 0) {
                response.media.forEach((media, index) => {
                    if (media.image_path) {
                        const previewId = `#editpreview${index + 1}`;
                        const imageUrl = `/images/${media.image_path}`;

                        $(previewId).attr('src', imageUrl).show();
                    }
                });
            }

            // **CORRECCIÓN: Seleccionar los filtros en el select2**
            let filters = [];

            if (response.filters && Array.isArray(response.filters)) {
                filters = response.filters;
                $('#edit_filter').val(response.filters).trigger('change');
            } else if (response.filter) {
                filters = Array.isArray(response.filter) ? response.filter : [response.filter];
                $('#edit_filter').val(filters).trigger('change');
            } else {
                $('#edit_filter').val(null).trigger('change');
            }
            console.log("Filtros:", filters);

            // Manejar destacado
            $('#editModal #destacado').val(response.destacado ? '1' : '0');

            // Inicializar Select2 y CKEditor después de mostrar el modal
            $('#editModal').one('shown.bs.modal', function() {
                console.log("Modal de edición abierto");

                // Inicializar Select2
                $('#edit_filter').select2({
                    placeholder: 'Selecciona filtros',
                    allowClear: true,
                    dropdownParent: $('#editModal'),
                    width: '100%'
                });

                // Destruir CKEditor antes de inicializarlo
                destroyCKEditor('#editModal #configuraciones');

                // Inicializar CKEditor
                initCKEditor('#editModal #configuraciones');
            }).modal('show'); // Mostrar el modal después de adjuntar el evento shown.bs.modal

        },
        error: function(xhr) {
            console.error('Error al obtener los datos del producto:', xhr.responseText);
            alert('Error al cargar los datos del producto.');
        }
    });
});

// --- Cerrar Modales ---
$('.modal .btn-close, .modal .btn-secondary').on('click', function() {
    $(this).closest('.modal').modal('hide');
});

// ==================== ORDENAMIENTO ====================
$('#toggleSortOrder').on('click', function() {
    const productList = $('#product-list');
    const sortableList = $('#sortableList');

    if (sortableList.is(':hidden')) {
        productList.hide();
        sortableList.show();
        $(this).text('Guardar Orden');

        // Inicializar Sortable cuando se muestra la lista
        if (!sortableList.data('sortable')) {
            new Sortable(sortableList[0], {
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag'
            });
            sortableList.data('sortable', true);
        }
    } else {
        // Recolectar el nuevo orden
        const newOrder = sortableList.find('li').map(function(index) {
            return {
                id: $(this).data('id'),
                order: index + 1 // Usar el índice actual como orden
            };
        }).get();

        // Enviar el nuevo orden al servidor
        $.ajax({
            url: "{{ route('admin.productos.reorder') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                order: newOrder
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    alert('Error al actualizar el orden');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert('Error al actualizar el orden');
            }
        });

        productList.show();
        sortableList.hide();
        $(this).text('Ordenar Productos');
    }
});

// Inicializar Sortable
if ($('#sortableList').length) {
    new Sortable($('#sortableList')[0], {
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag'
    });
}

// Handler del filtro
$('#filter').on('change', function() {
    let selectedFilters = $(this).val() || [];
    console.log('Filtros seleccionados:', selectedFilters);

    $.ajax({
        url: "{{ route('admin.filtrar') }}",
        type: 'GET',
        data: {
            filters: selectedFilters
        },
        beforeSend: function() {
            console.log('Enviando AJAX:', "{{ route('admin.filtrar') }}", {
                filters: selectedFilters
            }); // Agrega esta línea
        },
        success: function(response) {
            console.log('Respuesta AJAX:', response);
            if (response.html) {
                $('#product-list').html(response);
            }
        },
        error: function(xhr) {
            console.error('Error al filtrar productos:', xhr);
        }
    });
});

// Inicializar Select2 para el filtro del modal de edición
$('#edit_filter').select2({
    placeholder: 'Selecciona filtros',
    allowClear: true,
    dropdownParent: $('body'),
    width: '100%'
});

$('#add_filter').select2({
    placeholder: 'Selecciona filtros',
    allowClear: true,
    dropdownParent: $(
        'body'), // Asegúrate de que el dropdown se muestre dentro del modal
    width: '100%'
});

// Inicializar CKEditor en el modal de agregar producto cuando se muestra
$('#addProductModal').on('shown.bs.modal', function() {
    // Destruir CKEditor antes de inicializarlo
    destroyCKEditor('#addProductModal #configuraciones');

    initCKEditor('#addProductModal #configuraciones');
});
});
</script>

<style>
.modal.show {
display: block !important;
/* Agregar !important */
}

.modal-backdrop.show {
opacity: 0.5 !important;
/* Agregar !important */
}

.select2-dropdown {
z-index: 99999 !important;
}

/* Ajustes para modales */
.modal-body {
position: relative !important;
}

.modal-backdrop {
background-color: rgba(0, 0, 0, 0.5);
}

/* Estilos para la lista ordenable */
#searchInput {
padding: 10px 15px;
border-radius: 20px;
border: 1px solid #ddd;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
transition: all 0.3s ease;
}

#searchInput:focus {
outline: none;
border-color: #80bdff;
box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
}

#sortableList {
list-style: none;
padding: 20px;
background: #f8f9fa;
border-radius: 4px;
margin-top: 20px;
}

#sortableList li {
background: white;
padding: 15px;
margin-bottom: 10px;
border: 1px solid #dee2e6;
border-radius: 4px;
cursor: move;
display: flex;
align-items: center;
justify-content: space-between;
}

#sortableList li:hover {
background: #e9ecef;
}

.sortable-ghost {
opacity: 0.5;
background: #c8e6c9 !important;
}

.carousel-control-prev,
.carousel-control-next {
background-color: rgba(0, 0, 0, 0.3);
width: 40px;
height: 40px;
border-radius: 50%;
top: 50%;
transform: translateY(-50%);
margin: 0 10px;
}

.carousel-item {
background-color: #fff;
}

.card-img-container {
background-color: #fff;
display: flex;
align-items: center;
justify-content: center;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
width: 20px;
height: 20px;
}

/* Asegurarse de que los menús desplegables de TinyMCE se muestren por encima del modal */
.tox-menu {
z-index: 10000 !important;
top: auto !important;
left: auto !important;
}
</style>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection