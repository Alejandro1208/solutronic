@foreach ($productos->sortBy('order') as $producto)
    <div class="col-md-4">
        <div class="card h-100 shadow-sm product-card" data-id="{{ $producto->id }}" data-order="{{ $producto->order }}">
            <div class="carousel" id="carousel{{ $producto->id }}">
                @foreach ($producto->media as $media)
                    @if ($media->image_path)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ asset('images/' . $media->image_path) }}" alt="{{ $producto->titulo }}">
                        </div>
                    @endif
                    @if ($media->video_link)
                        <div class="carousel-item {{ $loop->first && !$media->image_path ? 'active' : '' }}">
                            <iframe class="video" width="560" height="315"
                                src="https://www.youtube.com/embed/{{ $media->video_link }}" frameborder="0"
                                allowfullscreen></iframe>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $producto->titulo }}</h5>
                <p class="card-text">{{ $producto->descripcion }}</p>
                <p>Código: {{ $producto->codigo }}</p>
                <p>Configuraciones: {{ $producto->configuraciones }}</p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary m-2 edit-button pb-0"
                            data-id="{{ $producto->id }}">Editar</button>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST">
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