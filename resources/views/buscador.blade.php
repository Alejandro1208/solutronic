@foreach($productos as $producto)
<div class="col-md-4 col-6">
    <div class="card h-100">
        @foreach($producto->media as $media)
            @if($media->image_path && $loop->first)
                <img src="{{ asset('images/' . $media->image_path) }}" class="card-img-top" alt="{{ $producto->titulo }}">
            @endif
        @endforeach
        <div class="card-body">
            <h5 class="card-title">{{ $producto->titulo }}</h5>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#productModal{{ $producto->id }}">Más info</button>
        </div>
    </div>
</div>

<!-- Aquí comienza el modal -->
<div class="modal fade" id="productModal{{ $producto->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $producto->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel{{ $producto->id }}">{{ $producto->titulo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Aquí comienza el cuerpo del modal -->
            <div class="modal-body">
                <div id="carouselModal{{ $producto->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($producto->media as $media)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                @if($media->image_path)
                                    <a href="{{ asset('images/' . $media->image_path) }}" data-lightbox="producto{{ $producto->id }}">
                                        <img src="{{ asset('images/' . $media->image_path) }}" class="d-block w-100 carousel-image-fixed" alt="{{ $producto->titulo }}">
                                    </a>
                                @elseif($media->video_link)
                                    <a href="https://www.youtube.com/embed/{{ $media->video_link }}" data-fancybox="producto{{ $producto->id }}">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $media->video_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselModal{{ $producto->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselModal{{ $producto->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <p>{{ $producto->descripcion }}</p>
                <p>Código: {{ $producto->codigo }}</p>
                <p>Configuraciones: {{ $producto->configuraciones }}</p>
            </div>
            <!-- Aquí termina el cuerpo del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Aquí termina el modal -->
@endforeach
