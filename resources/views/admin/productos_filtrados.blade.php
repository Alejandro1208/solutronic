<!-- Contenedor de tarjetas -->
        <div class="row g-4" id="product-list">
            @foreach ($productos->sortBy('order') as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <!-- Carousel for multiple images -->
                        <div id="carousel-{{ $producto->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($producto->media->where('image_path', '!=', null) as $index => $media)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('images/' . $media->image_path) }}" 
                                             class="d-block w-100" 
                                             style="height: 200px; object-fit: contain;"
                                             alt="Producto">
                                    </div>
                                @endforeach
                            </div>
                            @if($producto->media->where('image_path', '!=', null)->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $producto->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $producto->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->titulo }}</h5>
                            <p class="card-text">{{ $producto->descripcion }}</p>
                            <p>Código: {{ $producto->codigo }}</p>
                            <p>Configuraciones: {{ $producto->configuraciones }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div class="d-flex" style="height: 54px">
                                    <button type="button" 
                                    class="btn btn-primary m-2 edit-button pb-1 justify-content-center align-content-center"
                                    data-id="{{ $producto->id }}"
                                    data-filters="{{ $producto->filters }}" {{-- Agregar esta línea --}}
                                    >Editar</button>
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