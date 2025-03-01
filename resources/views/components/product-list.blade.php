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
    
            <div class="modal fade" id="productModal{{ $producto->id }}" tabindex="-1"
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
                                <div>
                                    <div class="product-info-container">
                                        <p>{{ $producto->descripcion }}</p>
                                        <p>Código: {{ $producto->codigo }}</p>
                                    </div>
                                    
                                    
                                    <div class="configuraciones-section">
                                        <p class="mb-0" >Configuraciones: {{ $producto->configuraciones }}</p>
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
                    Link copiado</div>
            </div>
        </div>
    @endforeach
    </div>