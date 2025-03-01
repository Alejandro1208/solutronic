<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solutronic</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
</head>
<body>
    <div class="app">
        <nav class="navbar navbar-expand-lg navbar-light" style="position: absolute; top: 10px; width: 100%; z-index: 10; background-color: rgba(255, 255, 255, 0%);">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="/">
                    <img src="img/logosf3.png" alt="Logo">
                </a>

                <!-- Botón para colapsar el menú en mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #ffffff73;">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menú colapsable -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Opciones izquierda -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" style="color: #FFFFFF;" href="https://www.solutronic.com.ar/quienes-somos">Nuestros Diseños</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #FFFFFF;" href="https://www.solutronic.com.ar/quienes-somos">¿Quiénes Somos?</a>
                        </li>
                    </ul>

                    <!-- Opciones derecha -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" style="color: #FFFFFF;" href="https://www.solutronic.com.ar/productos">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #FFFFFF;" href="https://www.solutronic.com.ar/redComercializacion">Red de Comercialización</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #FFFFFF;" href="https://www.solutronic.com.ar/contacto">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <style>
        .navbar-brand img {
            width: 150px;
        }

        .nav-link {
            margin-right: 10px;
            transition: color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .nav-link:hover {
            color: #ffffff !important;
            background-color: #FF00FF !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        /* Estado del menú colapsado */
        .navbar-collapse.show {
            background-color: rgba(0, 0, 0, 90%);
            opacity: 1;
            position: absolute;
            top: 60px;
            right: 0;
            width: 100%;
            z-index: 10;
            padding: 1rem;
            border-radius: 10px;
        }

        .navbar-nav .nav-link {
            color: #FFFFFF !important;
        }

        /* Asegurar que las opciones aparezcan una debajo de la otra en mobile */
        .navbar-nav {
            flex-direction: column;
        }

        /* Opciones en horizontal en escritorio */
        @media (min-width: 992px) {
            .navbar-nav {
                flex-direction: row;
            }
        }

        .navbar-nav .nav-item {
            margin-bottom: 10px;
        }

        /* Remover espacio extra en pantallas grandes */
        @media (min-width: 992px) {
            .navbar-nav .nav-item {
                margin-bottom: 0;
            }
        }
    </style>

        
        @include('components.banner')
        @include('components.quienes-somos')

        <!-------------- Productos Destacados  ----------------->
        <div class="row pt-5" style="background-color: #eceff3;margin-right: 0">
            <h2 class="text-center">Productos destacados</h2>
            <div class="container my-5">
                <!-- Carrusel para pantallas de escritorio -->
                <div id="carouselDesktop" style="width: 90%; margin: 0px auto;" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @php
                            $totalProducts = $featuredProducts->count();
                            $totalSlidesDesktop = ceil($totalProducts / 3);
                        @endphp
                        @for ($i = 0; $i < $totalSlidesDesktop; $i++)
                            <button type="button" data-bs-target="#carouselDesktop" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        @foreach($featuredProducts->chunk(3) as $index => $productChunk)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @foreach($productChunk as $product)
                                        <div class="col">
                                            <div class="card h-100 shadow-sm product-card">
                                                @if($product->media->count() > 0)
                                                    <img src="{{ asset('images/' . $product->media->first()->image_path) }}" class="product-img card-img-top" alt="{{ $product->titulo }}">
                                                @else
                                                    <img src="{{ asset('images/default-image.jpg') }}" class="product-img card-img-top" alt="{{ $product->titulo }}">
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $product->titulo }}</h5>
                                                    <p class="card-text">{{ $product->descripcion }}</p>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">Ver más</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDesktop" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselDesktop" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- Carrusel para pantallas móviles -->
                <div id="carouselMobile"  class="carousel slide d-block d-md-none" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @php
                            $totalSlidesMobile = $featuredProducts->count();
                        @endphp
                        @for ($i = 0; $i < $totalSlidesMobile; $i++)
                            <button type="button" data-bs-target="#carouselMobile" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        @foreach($featuredProducts as $index => $product)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row">
                                    <div class="col">
                                        <div class="card h-100 shadow-sm product-card">
                                            @if($product->media->count() > 0)
                                                <img src="{{ asset('images/' . $product->media->first()->image_path) }}" class="product-img card-img-top" alt="{{ $product->titulo }}">
                                            @else
                                                <img src="{{ asset('images/default-image.jpg') }}" class="product-img card-img-top" alt="{{ $product->titulo }}">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->titulo }}</h5>
                                                <p class="card-text">{{ $product->descripcion }}</p>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">Ver más</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMobile" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMobile" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Modales -->
            @foreach($featuredProducts as $product)
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->titulo }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="carouselModal{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->media as $media)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                @if($media->image_path)
                                                    <a href="{{ asset('images/' . $media->image_path) }}" data-lightbox="producto{{ $product->id }}">
                                                        <img src="{{ asset('images/' . $media->image_path) }}" class="d-block w-100 carousel-image-fixed" alt="{{ $product->titulo }}">
                                                    </a>
                                                @elseif($media->video_link)
                                                    <a href="https://www.youtube.com/embed/{{ $media->video_link }}" data-fancybox="producto{{ $product->id }}">
                                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $media->video_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselModal{{ $product->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselModal{{ $product->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <p>{{ $product->descripcion }}</p>
                                <p>Código: {{ $product->codigo }}</p>
                                <p>Configuraciones: {{ $product->configuraciones }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Fin Productos Destacados -->

        @include('components.footer')
    </div>
    <!-- Bootstrap JS y dependencias Popper.js y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    </script>
</body>
<style>
.product-card {
    position: relative;
    background-color: #f8f9fa;
    border-radius: 10px;
    overflow: visible; /* Permitir que el contenido se desborde */
    padding-bottom: 50px; /* Espacio adicional en la parte inferior para la superposición */
}

.product-img {
    width: 100%;
    height: auto;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.card-body {
    position: absolute;
    bottom: 1px; /* Ajusta este valor según la superposición deseada */
    width: 100%;
    text-align: center;
    background-color: white;
    opacity:80%;
    border-radius: 0px 0px 10px 10px;
    padding: 0px;

}
.card-body:hover {
    opacity:100%;
}
.card-title {
    margin-bottom: 15px;
    font-size: 1.25rem;
    font-weight: bold;
}

.card-text {
    margin-bottom: 20px;
}
.carousel-indicators,
.carousel-control-prev,
.carousel-control-next {
    display: none;
}


</style>
</html>
