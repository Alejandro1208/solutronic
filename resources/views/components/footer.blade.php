<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-md-3 text-center text-md-start mb-2 mb-md-0">
                    <img src="{{ asset('img/Solutronic-logo-scaled-1.webp') }}" alt="Logo" class="footer-logo">
                </div>
                <!-- Address and Contact Info -->
                <div class="col-md-5 text-center text-md-center mb-2 mb-md-0">
                    <p class="mb-1">
                        Valdenegro 4698<br>
                        Ciudad Autónoma de Buenos Aires<br>
                        República Argentina<br>
                        C.P.: C1430EFH
                    </p>
                    <p class="mb-1">
                        011-4546-3145 | Técnica<br>
                        011-4546-2563 | Comercialización<br>
                        E-mail: <a href="mailto:info@solutronic.com.ar" class="text-white">info@solutronic.com.ar</a> / <a href="mailto:ventas@solutronic.com.ar" class="text-white">ventas@solutronic.com.ar</a>
                    </p>
                    <div class="social-icons mt-2">
                        <a href="#" class="text-white me-2"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <!-- Menu -->
                <div class="col-md-4 text-center text-md-end">
                    <ul class="nav justify-content-center justify-content-md-end mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Quienes Somos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Red de Comercialización</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ url('/admin') }}" style="color: #ffffff !important;">Admin</a>
                        </li>
                    </ul>
                    <span>&copy; {{ date('Y') }} Solutronic SRL. All rights reserved.</span>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        .footer {
            background-color: #343a40;
        }
        .footer-logo {
            max-height: 30px;
        }
        .nav-link {
            color: #ffffff;
        }
        .nav-link:hover {
            color: #dddddd;
        }
        .social-icons a {
            font-size: 1.5rem;
        }
        footer p {
            margin-bottom: 0.5rem; /* Reduce el margen inferior de los párrafos */
        }
        .footer .nav-item {
            margin-bottom: 0.5rem; /* Espacio entre los elementos del menú en móvil */
        }
        .footer span {
            display: block; /* Asegura que el span ocupe toda la línea */
            margin-top: 1rem; /* Espacio superior para el span de copyright */
        }
    </style>
    
</body>
</html>
