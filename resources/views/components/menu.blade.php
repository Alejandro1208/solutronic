<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="{{ asset('img/Solutronic-logo-scaled-1.webp') }}" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/quienes-somos') }}">Quienes Somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/productos') }}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/redComercializacion')}}">Red de Comercialización</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contacto') }}" class="nav-link text-dark">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>

</script>

<style>
    .nav-link{
        margin-right: 10px
    }
    .navbar-brand img {
        width: 150px;
    }
    .nav-link {
        transition: color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        padding: 0.5rem 1rem; /* Añadir padding para mejor visualización */
        border-radius: 5px; /* Borde redondeado por defecto */
    }
    .nav-link:hover {
        color: #ffffff !important; /* Color del texto al hacer hover */
        background-color: #FF00FF !important; /* Color de fondo al hacer hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Efecto de sobresalir */
        border-radius: 8px; /* Bordes más redondeados al hacer hover */
    }
</style>
