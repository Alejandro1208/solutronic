@foreach ($productos as $producto)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm product-card">
                <div class="carousel" id="carousel{{ $producto->id }}">
                    @foreach ($producto->media as $media)
                    @if ($media->image_path)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('images/' . $media->image_path) }}" alt="{{ $producto->titulo }}">
                    </div>
                    @endif
                    @if ($media->video_link)
                    <div class="carousel-item {{ $loop->first && !$media->image_path ? 'active' : '' }}">
                        <iframe class="video" width="560" height="315" src="https://www.youtube.com/embed/{{ $media->video_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    @endif
                    @endforeach
                    <button class="carousel-control-prev">&#60;</button>
                    <button class="carousel-control-next">&#62;</button>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $producto->titulo }}</h5>
                    <p class="card-text">{{ $producto->descripcion }}</p>
                    <p>Código: {{ $producto->codigo }}</p>
                    <p>Configuraciones: {{ $producto->configuraciones }}</p>
                    <div class="mt-auto d-flex justify-content-between">
                    <a href="#" class="btn btn-primary mb-2 edit-button" data-id="{{ $producto->id }}">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
