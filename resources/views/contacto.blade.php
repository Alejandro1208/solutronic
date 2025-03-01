<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacto - Solutronic</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
    <style>
        /* Banner CSS */
        .hero {
            background: url('{{ asset('img/banners/contacto41.png') }}') no-repeat center center;
            background-size: auto;
            color: #000000;
            padding: 70px 0;
            opacity: 1;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.25rem;
        }
        .section-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #007bff;
        }
        .contact-info {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
        }
        .contact-info h5 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #007bff;
        }
        .contact-info p {
            margin-bottom: 5px;
        }
        /* Contacto CSS */
        .contact-form {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 11px 13px 10px rgba(0, 0, 0, 0.1);
        }
        .contact-form h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .contact-form .form-label {
            font-weight: bold;
        }
        .contact-form .form-control {
            border-radius: 5px;
        }
        .contact-form textarea.form-control {
            resize: vertical;
        }
        .contact-form .btn-primary {
            width: 30%;
            border-radius: 5px;
            background-color: #FF00FF;
            border-color: #FF00FF;
        }
        .contact-form .btn-primary:hover {
            background-color: #bb0abb;
            border-color: #c303c3;
        }
        .contacto{
            background-color: #ffffff;
        }
    </style>
</head>
<body>    
    @include('components.menu')
    <header class="hero text-center">
        <div class="container">
            <br>
            <br>
            <br>
            <h1>Contacto</h1>
            <p>Aportando soluciones electrónicas confiables y accesibles</p>
        </div>
    </header>
<!-- Contacto seccion --->
    <div class="container-full p-5 contacto">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form">
                    <h2 class="text-center">Dejanos tu mensajes</h2>
                    <form action="{{ route('contacto.enviar') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Fin Contacto seccion --->

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @include('components.footer')
    <!-- Bootstrap JS y dependencias Popper.js y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
</body>
</html>
