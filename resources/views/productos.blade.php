<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<!-- CSS Files -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<title>Productos</title>
<style>
    /* Estilos generales */
    footer {
        width: 100%;
        margin: 0;
    }

    /* Estilos para las tarjetas de productos */
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }

    .card-text {
        font-size: 1rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .btn-info {
        background-color: #FF00FF;
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        transition: background-color 0.2s;
    }

    .btn-info:hover {
        background-color: #b006b0;
        color: #fff;
    }

    h2 {
        margin-bottom: 2rem;
        font-size: 2.5rem;
        font-weight: 700;
    }

    /* Estilos para el select de filtro */
    #filter {
        width: 50%;
        margin: 20px auto;
        padding: 10px;
        font-size: 1.2em;
        border: none;
        border-radius: 5px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        transition: box-shadow 0.3s ease;
    }

    #filter:focus {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.32), 0 5px 15px rgba(0, 0, 0, 0.19);
    }

    /* Estilos para los modales */
    body .container .modal-content {
        width: 90vw !important;
        height: 90vh !important;
        /* Modal más grande (90% del ancho de la ventana) */
        max-width: 1500px !important;
        /* Ancho máximo del modal */
    }

    .modal-dialog {
        max-width: none !important;
        /* Anula el max-width del media query */
        margin-left: auto !important;
        margin-right: auto !important;
    }

    @media (min-width: 992px) {
        .modal-lg {
            max-width: 1500px;
            /* Ajusta el ancho máximo del modal grande */
        }
    }

    @media (max-width: 768px) {
        .contenedorInfo {
            flex-direction: column;
            height: auto;
        }

        .product-image-container,
        .product-info-container {
            flex: 1 1 100%;
            width: 100%;
            margin-right: 0;
        }

        .modal-body {
            padding: 1rem;
        }

        body .container .modal-content {
            height: auto !important;
        }
    }

    .modal-body {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-container {
        /* O el selector del contenedor del modal */
        display: flex;
        justify-content: center;
        /* Centra horizontalmente */
        align-items: center;
        /* Centra verticalmente (opcional) */
    }

    .contenedorInfo {
        display: flex;
        gap: 20px;
        width: 90%;
        height: 90%;
        /* Espacio entre la imagen y la información */
    }

    .product-image-container {
        flex: 0 0 50%;
        /* La imagen ocupa el 50% del ancho */
        border: 1px solid gray;
        /* Borde gris de 1px */
        padding: 10px;
        /* Espacio interno para separar el contenido del borde */
        text-align: center;
        /* Centra la imagen */
    }

    .product-info-container {
        flex: 1;
        /* El texto ocupa el espacio restante */
        border: 1px solid gray;
        /* Borde gris de 1px */
        padding: 10px;
        /* Espacio interno */
    }

    .configuraciones-section {
        margin-top: 15px;
        border: 1px solid #dee2e6;
        padding: 15px;
        border-radius: 4px;
    }

    .configuraciones-section h5 {
        margin-bottom: 15px;
        color: #333;
    }

    .configuraciones-section .table {
        margin-bottom: 0;
    }

    .configuraciones-section .table td {
        padding: 8px;
        vertical-align: middle;
    }

    .table-sm {
        font-size: 0.9rem;
    }

    .modal-body .product-image-container {
        /*Contenedor de la imagen dentro del modal*/
        flex: 0 0 50%;
        margin-right: 20px;
        text-align: center;
        /* Centra la imagen horizontalmente */
    }

    .modal-body .product-info-container {
        /*Contenedor de la información del producto*/
        flex: 1;
    }

    .carousel-image-fixed {
        max-width: 100%;
        /* La imagen se ajusta al contenedor del carrusel */
        height: auto;
        display: block;
        /* Evita que la imagen se salga del contenedor */
        margin-left: auto;
        margin-right: auto;
    }

    /* Estilos para el botón de búsqueda */
    .btn-outline-success {
        background-color: #FF00FF;
        color: white;
        border: none;
    }

    .btn-outline-success:hover {
        background-color: #b006b0;
    }

    /* Estilos para la paginación */
    .pagination .active .page-link {
        background-color: #FF00FF;
        border-color: #FF00FF;
        color: #fff;
    }

    .pagination .page-link {
        color: #FF00FF;
    }

    .pagination .page-link:hover {
        background-color: #FF00FF;
        color: #fff;
    }

    /* Estilos para iframes dentro del modal */
    .modal-body iframe {
        display: block;
        margin: 0 auto;
        max-width: 100%;
    }
</style>
</head>

<body>
@include('components.menu')

<div class="container my-5">
    <h2 class="text-center">Nuestros Productos</h2>

    <select name="filter[]" id="filter" class="form-control select2-multiple" multiple="multiple">
        <option value="todos">Todos los productos</option>
        <option value="Automotor" data-parent="true">Automotor</option>
        <option value="Lamparas Electronica" data-category="Automotor">Lámparas Electrónica</option>
        <option value="Medidores de bateria" data-category="Automotor">Medidores de batería</option>

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
    <!-- Reemplazar el formulario de búsqueda actual con este -->
    <div class="d-flex m-4">
        <input type="text" id="searchInput" class="form-control me-2" placeholder="Buscar productos...">
    </div>
    <div id="product-list" class="row g-4">
        @foreach ($productos as $producto)
            <div class="col-md-4 col-6">
                <div class="card h-100">
                    @if ($producto->media->first())
                        <a href="{{ asset('images/' . $producto->media->first()->image_path) }}"
                            data-lightbox="producto{{ $producto->id }}">
                            <img src="{{ asset('images/' . $producto->media->first()->image_path) }}"
                                class="card-img-top" alt="{{ $producto->titulo }}">
                        </a>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->titulo }}</h5>
                        <p class="card-text">{{ $producto->descripcion }}</p>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#productModal{{ $producto->id }}">Más info</button>
                    </div>
                </div>
            </div>

            <div style="margin-left: 5%" class="modal fade" id="productModal{{ $producto->id }}" tabindex="-1"
                aria-labelledby="productModalLabel{{ $producto->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title d-flex align-items-center"
                                id="productModalLabel{{ $producto->id }}">
                                {{ $producto->titulo }}
                                @if ($producto->id == 1 || $producto->id == 2)
                                    <button type="button" class="btn btn-secondary btn-sm ms-3"
                                        id="extraInfoBtn{{ $producto->id }}" style="background-color: #0d6efd;">
                                        @if ($producto->id == 1)
                                            P03 6L
                                        @else
                                            P04 6L
                                        @endif
                                    </button>
                                @endif
                                <button type="button" class="btn btn-secondary btn-sm ms-3"
                                    style="background-color: #90cb3e;"
                                    onclick="downloadFichaTecnica({{ $producto->id }})">Ficha Técnica</button>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="mainInfo{{ $producto->id }}" class="contenedorInfo">
                                <div class="product-image-container">
                                    <div id="carouselModal{{ $producto->id }}" class="carousel slide"
                                        data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($producto->media as $media)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    @if ($media->image_path)
                                                        <a href="{{ asset('images/' . $media->image_path) }}"
                                                            data-lightbox="producto{{ $producto->id }}">
                                                            <img src="{{ asset('images/' . $media->image_path) }}"
                                                                class="d-block w-100 carousel-image-fixed"
                                                                alt="{{ $producto->titulo }}">
                                                        </a>
                                                    @elseif($media->video_link)
                                                        <a href="https://www.youtube.com/embed/{{ $media->video_link }}"
                                                            data-fancybox="producto{{ $producto->id }}">
                                                            <iframe width="560" height="315"
                                                                src="https://www.youtube.com/embed/{{ $media->video_link }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen></iframe>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <div class="cnt" style="width: 100%">
                                    <div class="product-info-container">
                                        <h5 class="configuraciones-title text-center mb-2">Descripcion</h5>
                                        <p>{{ $producto->descripcion }}</p>
                                        <h5 class="configuraciones-title mb-2">Codigo</h5>
                                        <p>{{ $producto->codigo }}</p>
                                    </div>

                                    <div class="configuraciones-section">
                                        <h5 class="configuraciones-title text-center mb-4">Configuraciones</h5>
                                        <div class="table-responsive"
                                            style="max-height: 200px; overflow-y: auto;">
                                            <table class="table table-sm table-bordered table-striped">
                                                <tbody>
                                                    @php
                                                        if (is_string($producto->configuraciones)) {
                                                            // Si es una cadena, dividir por el guión
                                                            $configs = array_map(
                                                                'trim',
                                                                explode('-', $producto->configuraciones),
                                                            );
                                                        } elseif (is_array($producto->configuraciones)) {
                                                            $configs = $producto->configuraciones;
                                                        } else {
                                                            $configs = [];
                                                        }
                                                    @endphp
                                                    @if (count($configs) > 0)
                                                        @foreach ($configs as $config)
                                                            @if (!empty($config))
                                                                <tr>
                                                                    <td class="text-center">{{ $config }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="text-center text-muted">Sin configuraciones
                                                                cargadas</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="extraInfo{{ $producto->id }}" style="display: none;">
                                @if ($producto->id == 1)
                                    <img src="img/P036l.jpg" class="d-block w-100 carousel-image-fixed"
                                        alt="{{ $producto->titulo }}">
                                @elseif ($producto->id == 2)
                                    <img src="img/1LAP046BSOL2.png" class="d-block w-100 carousel-image-fixed"
                                        alt="{{ $producto->titulo }}">
                                @endif
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"
                                onclick="copyModalUrl('{{ $producto->id }}')">Compartir</button>
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
                <div id="copyMessage{{ $producto->id }}"
                    style="display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000;">
                    Link copiado
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation example">
            <div class="d-flex justify-content-center">
                {{ $productos->links() }}
            </div>
        </nav>
    </div>
</div>

@include('components.footer')
<!-- JavaScript Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<!-- Initialize components after all dependencies are loaded -->
<script>
    jQuery(document).ready(function($) {
        // Función para copiar URL del producto
        window.copyModalUrl = function(productId) {
            // Crear la URL para el producto específico
            const url = `${window.location.origin}/producto/${productId}`;

            // Copiar al portapapeles
            navigator.clipboard.writeText(url).then(() => {
                // Mostrar mensaje de éxito
                const messageElement = document.getElementById(`copyMessage${productId}`);
                if (messageElement) {
                    messageElement.style.display = 'block';

                    // Ocultar mensaje después de 2 segundos
                    setTimeout(() => {
                        messageElement.style.display = 'none';
                    }, 2000);
                }
            }).catch(err => {
                console.error('Error al copiar URL:', err);
                alert('No se pudo copiar la URL');
            });
        };

        // Inicializar Select2
        $('#filter').select2({
            placeholder: 'Selecciona categorías',
            allowClear: true,
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatSelection,
            closeOnSelect: false
        });
        // Manejar cambios en el filtro
        $('#filter').on('change', function() {
            let selectedValues = $(this).val() || [];

            // Si "todos" está seleccionado, deseleccionar las demás opciones
            if (selectedValues.includes('todos')) {
                $(this).val(['todos']).trigger('change.select2');
                selectedValues = ['todos'];
            }

            actualizarProductos(selectedValues);
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }

            var $option = $(option.element);
            var $result = $('<span></span>');

            if ($option.attr('data-parent')) {
                $result.addClass('parent-option').text(option.text);
            } else {
                $result.addClass('child-option').text(option.text);
            }

            return $result;
        }

        function formatSelection(option) {
            return option.text;
        }

        // Manejar cambios en los filtros
        $('#filter').on('change', function() {
            let selectedValues = $(this).val() || [];
            actualizarProductos(selectedValues);
        });

        function actualizarProductos(filters) {
            // Si filters es null o está vacío, mostrar todos los productos
            if (!filters || filters.includes('todos')) {
                filters = [];  // Enviar array vacío para mostrar todos los productos
            }

            $.ajax({
                url: "{{ route('productos.index') }}",
                type: 'GET',
                data: {
                    filters: filters
                },
                success: function(response) {
                    console.log('Respuesta recibida:', response);

                    if (response.html) {
                        $('#product-list').empty().html(response.html);
                        initializePlugins();

                        if (response.pagination) {
                            $('.pagination').html(response.pagination);
                        }
                    } else {
                        $('#product-list').html(
                            '<div class="col-12 text-center"><p>No se encontraron productos</p></div>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar productos:', error);
                    $('#product-list').html(
                        '<div class="col-12 text-center"><p>Error al cargar los productos</p></div>'
                    );
                }
            });
        }

        function initializePlugins() {
            // Reinicializar Lightbox
            if (typeof lightbox !== 'undefined') {
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true
                });
            }

            // Reinicializar Fancybox
            if ($.fancybox) {
                $('[data-fancybox]').fancybox({
                    youtube: {
                        controls: 1,
                        showinfo: 1
                    }
                });
            }
        }
    });
    let typingTimer;
    const doneTypingInterval = 300; // tiempo en milisegundos

    // Función para actualizar productos
    function actualizarProductos(filters = null, search = null) {
        $.ajax({
            url: "{{ route('productos.index') }}",
            type: 'GET',
            data: {
                filters: filters,
                search: search
            },
            success: function(response) {
                if (response.html) {
                    $('#product-list').empty().html(response.html);

                    if (response.pagination) {
                        $('.pagination').html(response.pagination);
                    }

                    // Reinicializar plugins si es necesario
                    initializePlugins();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Evento para la búsqueda en vivo
    $(document).on('keyup', '#searchInput', function() {
        clearTimeout(typingTimer);
        const searchText = $(this).val();
        const selectedFilters = $('#filterSelect').val();

        // Solo hacer la búsqueda si hay 2 o más caracteres o si el campo está vacío
        if (searchText.length >= 2 || searchText.length === 0) {
            typingTimer = setTimeout(function() {
                actualizarProductos(selectedFilters, searchText);
            }, doneTypingInterval);
        }
    });

    // Evento para los filtros
    $('#filterSelect').on('change', function() {
        const selectedFilters = $(this).val();
        const searchText = $('#searchInput').val();
        actualizarProductos(selectedFilters, searchText);
    });
    // Create the URL for the specific product
    const url = `${window.location.origin}/producto/${productId}`;
</script>
</body>

</html>