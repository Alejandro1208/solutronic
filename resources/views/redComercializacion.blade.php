<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Red de Comercialización - Solutronic</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
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
        </style>
    </head>
    <body>
        @include('components.menu')
        <header class="hero text-center">
            <div class="container">
                <h1>Solutronic</h1>
                <p>Aportando soluciones electrónicas confiables y accesibles</p>
            </div>
        </header>
        <main class="container my-5">
            <!-- Mapa de Google -->
            <section>
                <h2 class="section-title">Mapa de Distribuidores</h2>
                <iframe src="https://www.google.com/maps/d/embed?mid=1DK9M40rpk5twtn6jmsuubzOr-ULh7c8j&ehbc=2E312F" width="100%" height="480"></iframe>
            </section>
            <!-- Lista de Distribuidores -->
            <section class="my-5">
                <h2 class="section-title">Red de Comercialización</h2>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>CAMPOMAR S.A.</h5>
                            <p>Av. Warnes 1255</p>
                            <p>Ciudad Autónoma de Buenos Aires</p>
                            <p>Tel. 4855-1035</p>
                            <p>E-mail: distribuidora@campomarsa.com.ar</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>DER S.A. Distribuidora</h5>
                            <p>Av. Panamericana</p>
                            <p>Colectora Este Km. 28</p>
                            <p>Don Torcuato – Buenos Aires</p>
                            <p>Tel. 4846-7500</p>
                            <p>E-mail: info@derdistribuciones.com.ar</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>BENETTI Distribuciones & servicios S.R.L</h5>
                            <p>Av. Hipolito Yrigoyen (Ex Ruta 197) 1578</p>
                            <p>El Talar – Buenos Aires</p>
                            <p>Tel. 4726-6553 / 1550963476</p>
                            <p>E-mail: talar@benettisrl.com.ar</p>
                        </div>
                    </div>
                    <!-- Agrega tus tarjetas aquí -->
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>ELECTROMECANICA SUR</h5>
                            <p>Av. Hipólito Irigoyen 10157</p>
                            <p>Temperley – Buenos Aires</p>
                            <p>Tel. 4292-9905</p>
                            <p>E-mail: electromecanicasur157@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>REPUESTOS DE DIOS S.R.L.</h5>
                            <p>Av. Colón 5590</p>
                            <p>Mar del Plata</p>
                            <p>Tel. 0223-475 4284/5</p>
                            <p>E-mail: ventas@repuestosdedios.com.ar</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>ROBERTO ECHEVARNE</h5>
                            <p>Av. Primera Junta 104</p>
                            <p>Junín, Buenos Aires</p>
                            <p>Tel.: 02362-43 4583</p>
                            <p>www.echevarnehnos.com</p>
                            <p>E-mail: mauro@echevarnehnos.com</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>AUTOREPUESTOS MyL</h5>
                            <p>Juan B. Justo 3841</p>
                            <p>Córdoba – Córdoba</p>
                            <p>Tel. 0351-470 9100</p>
                            <p>E-mail: ventas@autorepuestosmyl.com.ar</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>IMPERDIEL – COREMFA S.A.</h5>
                            <p>La Rioja 761</p>
                            <p>Río Cuarto – Córdoba</p>
                            <p>Tel. 0358-463 8569 / 465 4108</p>
                            <p>E-mail: imperdiel@aspnet.com.ar</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>HRM DISTRIBUCIONES</h5>
                            <p>Sarmiento 1185</p>
                            <p>Villa María – Córdoba</p>
                            <p>Tel. 0353 15-6570522</p>
                            <p>E-mail: administracion@hrmdistribuidora.com.ar</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>MAUGER S.R.L.</h5>
                            <p>Eusebio Marcilla 650 PB</p>
                            <p>Córdoba</p>
                            <p>Tel. 0351-473 2026 ó Móvil 0351- 15 5167531</p>
                            <p>E-mail: maugersrl@arnet.com.ar o</p>
                            <p>E-mail: maugersrl@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="contact-info">
                            <h5>CARLOS ANDRETICH S.A.</h5>
                            <p>Paul Harris 136</p>
                            <p>Rafaela – Santa Fe</p>
                            <p>Tel. 03492-43 3936/43 1744</p>
                            <p>E-mail: info@carlosandretich.com.ar</p>
                        </div>

                    </div>
                </div>
            </section>
        </main>
        @include('components.footer')
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    </body>
</html>