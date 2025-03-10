<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
    <title>Autoelevadores</title>
    <style>
        footer {
    width: 100%;
    margin: 0;
}
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
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
        #filter {
    width: 50%; /* Ajusta este valor a tu gusto */
    margin: 20px auto; /* Añade un margen arriba y abajo */
    padding: 10px;
    font-size: 1.2em;
    border: none;
    border-radius: 5px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    transition: box-shadow 0.3s ease;
}

#filter:focus {
    box-shadow: 0 5px 15px rgba(0,0,0,0.32), 0 5px 15px rgba(0,0,0,0.19);
}
.carousel-image-fixed {
    width: 330px;  /* Ajusta este valor a tu gusto */
    height: 300px;  /* Ajusta este valor a tu gusto */
    object-fit: cover;  /* Esto hará que la imagen cubra el área definida sin deformarse */
}
.modal-content{
    width: 100% !important;
}
.btn-outline-success{
    background-color: #FF00FF;
    color: white;
    border: none;
}
.btn-outline-success:hover{
    background-color: #b006b0;
}
/* Cambia el color de fondo y el texto del elemento activo */
.pagination .active .page-link {
    background-color: #FF00FF;
    border-color: #FF00FF;
    color: #fff; /* Color del texto */
}
.pagination .page-link {
    color: #FF00FF;
}

/* Cambia el color de fondo y el texto al pasar el cursor sobre un elemento */
.pagination .page-link:hover {
    background-color: #FF00FF;
    color: #fff; /* Color del texto */
}

    </style>
</head>
<body>
    <?php echo $__env->make('components.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
   

    <div class="container my-5">
        <h2 class="text-center" >Nuestros Productos</h2>
<select name="filter" id="filter" class="form-control">
    <option value="" selected disabled>Seleccione un filtro...</option>
    <option value="<?php echo e(route('productos.all')); ?>">Mostrar todos</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Automotor'])); ?>" disabled>Automotor</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Lamparas Electronica'])); ?>">&nbsp;&nbsp;Lámparas electrónica</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Medidores de bateria'])); ?>">&nbsp;&nbsp;Medidores de batería</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Luminarias'])); ?>" disabled>Luminarias</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Luminaria'])); ?>">&nbsp;&nbsp;Luminaria</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Portatil'])); ?>">&nbsp;&nbsp;Portátil</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Reflectores'])); ?>">&nbsp;&nbsp;Reflectores</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Balizas'])); ?>"style="color: #8C9094;">&nbsp;&nbsp;Autoelevadores</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Balizas'])); ?>">&nbsp;&nbsp;Balizas</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Seguridad'])); ?>">&nbsp;&nbsp;Seguridad</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Energias Alternativas'])); ?>" disabled>Energías Alternativas</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'iluminacion'])); ?>">&nbsp;&nbsp;Iluminación</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'reguladores'])); ?>">&nbsp;&nbsp;Reguladores</option>
    <option value="<?php echo e(route('productos.index', ['filter' => 'Solar'])); ?>">&nbsp;&nbsp;Solar</option>
</select>
<form id="search-form" action="<?php echo e(route('productos.index')); ?>" method="GET" class="d-flex m-4">
    <input type="text" name="search" class="form-control me-2" placeholder="Buscar productos..." required>
    <button id="search-btn" class="btn btn-outline-success" type="submit">Buscar</button>
</form>
<div id="product-list" class="row g-4"> 
            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-6">
                <div class="card h-100" style="<?php echo e($producto->id != 1 ? 'display: none;' : ''); ?>">
                        <?php $__currentLoopData = $producto->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($media->image_path && $loop->first): ?>
                            <a href="<?php echo e(asset('images/' . $media->image_path)); ?>" data-lightbox="producto<?php echo e($producto->id); ?>">
                                <img src="<?php echo e(asset('images/' . $media->image_path)); ?>" class="card-img-top" alt="<?php echo e($producto->titulo); ?>">
                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($producto->titulo); ?></h5>
                            <?php if($producto->id == 1): ?>
                            <a href="img/1800ba.jpg" data-lightbox="example-1">
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 850/930/1800/1820</h3>
                            </a>
                            <?php endif; ?>
                            <?php if($producto->id == 2): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 1035 y Ap400/430</h3>
                            <?php endif; ?>
                            <?php if($producto->id == 3): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 634 640</h3>
                            <?php endif; ?>
                            <?php if($producto->id == 4): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 1600</h3>
                            <?php endif; ?>
                            <?php if($producto->id == 5): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo Portalámpara T10</h3>
                            <?php endif; ?>
                            <?php if($producto->id == 6): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 1400</h3>
                            <?php endif; ?>
                            <?php if($producto->id == 7): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 1037 630</h3>
                            <?php endif; ?>
                            <?php if($producto->id == 8): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 1830 930/07</h3>
                            <?php endif; ?>
                            <?php if($producto->id == 9): ?>
                            <h3 class="card-text">Lámpara electrónica reemplazo tipo 68030-1350-710-1215-1938</h3>
                            <?php endif; ?>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#productModal<?php echo e($producto->id); ?>">Más info</button>
                            
                        </div>
                    </div>
                </div>

                <!-- Aquí comienza el modal -->
                <div class="modal fade" id="productModal<?php echo e($producto->id); ?>" tabindex="-1" aria-labelledby="productModalLabel<?php echo e($producto->id); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel<?php echo e($producto->id); ?>"><?php echo e($producto->titulo); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Aquí comienza el cuerpo del modal -->
                            <div class="modal-body">
                                <div id="carouselModal<?php echo e($producto->id); ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php $__currentLoopData = $producto->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>">
                                                <?php if($media->image_path): ?>
                                                    <a href="<?php echo e(asset('images/' . $media->image_path)); ?>" data-lightbox="producto<?php echo e($producto->id); ?>">
                                                        <img src="<?php echo e(asset('images/' . $media->image_path)); ?>" class="d-block w-100 carousel-image-fixed" alt="<?php echo e($producto->titulo); ?>">
                                                    </a>
                                                <?php elseif($media->video_link): ?>
                                                    <a href="https://www.youtube.com/embed/<?php echo e($media->video_link); ?>" data-fancybox="producto<?php echo e($producto->id); ?>">
                                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo e($media->video_link); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselModal<?php echo e($producto->id); ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselModal<?php echo e($producto->id); ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <p><?php echo e($producto->descripcion); ?></p>
                                <p>Código: <?php echo e($producto->codigo); ?></p>
                                <p>Configuraciones: <?php echo e($producto->configuraciones); ?></p>
                            </div>
                            <!-- Aquí termina el cuerpo del modal -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Aquí termina el modal -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Page navigation example">
                <ul id="pagination" class="pagination">
                    <!-- Tus elementos de paginación aquí -->
                </ul>
            </nav>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        if (window.location.hash) {
            var modalId = window.location.hash;
            $(modalId).modal('show');
        }
    });
</script>
    <script>
$('#search-form input[name="search"]').on('input', function() {
    var url = $('#search-form').attr('action');
    var search = $(this).val();

    $.get(url, { search: search }, function(data) {
        $('#product-list').html(data);
        paginate();
        // Reinicializa los eventos de Bootstrap en los nuevos elementos
        var modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
        modalTriggers.forEach(function(trigger) {
            var target = document.querySelector(trigger.dataset.bsTarget);
            var modal = bootstrap.Modal.getInstance(target);
            if (modal) {
                modal.dispose();
            }
            new bootstrap.Modal(target);
        });
    });
});
</script>
    <script>
            function paginate() {
        var numItems = $('#product-list .col-md-4').length;
        var perPage = 9;

        // Solo muestra los primeros 9 productos
        $('#product-list .col-md-4').slice(perPage).hide();

        // Calcula el número de páginas
        var numPages = Math.ceil(numItems / perPage);

        // Agrega controles de paginación
        $('#pagination').empty();
        for (i = 0; i < numPages; i++) {
            $('<li class="page-item"><a class="page-link" href="#"  onclick="window.scrollTo(0, 0);">' + (i + 1) + '</a></li>').appendTo('#pagination');
            window.onload = function() {
        window.scrollTo(0, 0);
    };
       
        }

        // Resalta la primera página
        $('#pagination .page-item').first().addClass('active');

        // Maneja el clic en un número de página
        $('#pagination .page-item').click(function(e) {
            e.preventDefault();

            var pageNum = $(this).text();

            // Oculta todos los productos
            $('#product-list .col-md-4').hide();

            // Muestra solo los productos de esta página
            var start = (pageNum - 1) * perPage;
            var end = start + perPage;
            $('#product-list .col-md-4').slice(start, end).show();

            // Resalta el número de página actual
            $('#pagination .page-item').removeClass('active');
            $(this).addClass('active');
        });
    }

$(document).ready(function() {
    $('#filter').change(function() {
        var selectedOption = $(this).find('option:selected');
        var filter = selectedOption.text();
        var url = "<?php echo e(route('productos.index')); ?>"; // URL base

        // Si NO es "Mostrar todos", agrega el parámetro de filtro
        if (filter !== "Mostrar todos") {
            url += "?filter=" + filter; 
        }

        console.log('Enviando solicitud AJAX a:', url); 

        $.get(url, function(data) {
            console.log('Respuesta del servidor:', data);
            $('#product-list').html(data);
            paginate();

            // Reinicializa los eventos de Bootstrap en los nuevos elementos
            var modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
            modalTriggers.forEach(function(trigger) {
                var target = document.querySelector(trigger.dataset.bsTarget);
                var modal = bootstrap.Modal.getInstance(target);
                if (modal) {
                    modal.dispose();
                }
                new bootstrap.Modal(target);
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log('Error en la solicitud AJAX:', textStatus, errorThrown);
        });
    }); 

    // Llama a la función paginate cuando la página se carga por primera vez
    paginate();
});
        </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var productId = <?php echo e($productId ?? 'null'); ?>;
        if (productId) {
            var modalId = '#productModal' + productId;
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        }
    });
</script>
    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Bootstrap JS y dependencias Popper.js y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
</body>
</html>
<?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/autoelevadores.blade.php ENDPATH**/ ?>