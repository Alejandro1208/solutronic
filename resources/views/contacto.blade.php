<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacto - Solutronic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Banner CSS */
        .hero {
            background: url('{{ asset('img/banners/auto-electrico-scaled.webp') }}') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 100px 0;
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
            background-color: #f8f9fa;
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            width: 100%;
            border-radius: 5px;
            background-color: #FF00FF;
            border-color: #FF00FF;
        }
        .contact-form .btn-primary:hover {
            background-color: #bb0abb;
            border-color: #c303c3;
        }
        .contacto{
            background-color: #ff00ff7d;
        }
    </style>
</head>
<body>    
    @include('components.menu')
    <header class="hero text-center">
        <div class="container">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
