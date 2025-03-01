<div id="product-list">
    @foreach($productos as $producto)
        <div class="col-md-4 mb-4">
            <div class="card product-card">
                <!-- Mantén el mismo contenido de las cards que tienes en admin.blade.php -->
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->titulo }}</h5>
                    <!-- ... resto del contenido de la card ... -->
                </div>
            </div>
        </div>
    @endforeach
</div>