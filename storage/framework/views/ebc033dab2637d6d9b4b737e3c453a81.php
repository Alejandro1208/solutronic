<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quienes Somos - Solutronic</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- En la sección head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('<?php echo e(asset('img/banners/auto-electrico-scaled.webp')); ?>') no-repeat center center;
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
    <?php echo $__env->make('components.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <header class="hero text-center">
        <div class="container">
            <h1>Solutronic</h1>
            <p>Aportando soluciones electrónicas confiables y accesibles</p>
        </div>
    </header>

    
    <main class="container my-5">
        <section>
            <h2 class="section-title">Un trabajo enfocado en dar soluciones</h2>
            <p>Solutronic es un emprendimiento destinado a aportar soluciones electrónicas tendientes a facilitar el trabajo, resolver necesidades en distintos ámbitos desarrollando productos confiables, y al mismo tiempo reconozcan un costo razonable.</p>
            <p>La empresa es una iniciativa de emprendedores argentinos que se propone brindar al mercado productos de calidad, con presentación adecuada, que brinde al consumidor toda la información necesaria para su correcto uso y aprovechamiento.</p>
            <p>Al mismo tiempo brinda garantía comprobable de sus productos, pues repondrá automáticamente las unidades con desperfectos –durante los seis primeros meses de uso-.</p>
            <p>A lo largo de estos pocos años se han ido desarrollando diversos artículos, que se introducen en el mercado eléctrico, automotriz y de las energías alternativas o renovables, y más recientemente el de iluminación a LEDs, con la fuerza que les otorga su calidad y presentación.</p>
            <p>Estamos en constante crecimiento, desarrollando en forma permanente nuevos productos y “Soluciones” habiendo abordado, con mucha fuerza en estos últimos 15 años, el terreno de la iluminación con LEDs, en especial del transporte automotor, de pasajeros y carga, ferroviario y firmes intenciones de abordar otros segmentos del mismo negocio.</p>
            <p>Te invitamos a comunicarse con nosotros para que nos cuente sobre usted y sus comentarios, con gusto hablaremos sobre como solucionar posibles problemas y/o como optimizar el proyecto siempre que se pueda pero sin descuidar la calidad</p>
        </section>
        
        <section class="my-5">
            <h2 class="section-title">Información de Contacto</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <h5>Domicilio Comercial</h5>
                        <p>Valdenegro 4698</p>
                        <p>Ciudad Autónoma de Buenos Aires</p>
                        <p>República Argentina</p>
                        <p>C.P.: C1430DLA</p>
                        <p>Teléfono: (011) 4546-2563</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-info">
                        <h5>E-Mail</h5>
                        <p>info@solutronic.com.ar</p>
                        <p>ventas@solutronic.com.ar</p>
                    </div>
                    <div class="contact-info mt-4">
                        <h5>Información Fiscal</h5>
                        <p>AFIP CUIT 33-61013885-9</p>
                        <p>DGR Ingresos Brutos</p>
                        <p>Convenio Multilateral- 901-225470-1</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="text-center my-5">
            <h2 class="section-title">SOLUTRONIC S.R.L.</h2>
            <p>SOLUTRONIC® Es Marca Reg. Inscripta En La IGJ El 1/11/2006 Bajo El Nro. 9817 Del Libro 125 De SRL</p>
        </section>
    </main>
    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Bootstrap JS y dependencias Popper.js y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
    <!-- Antes de cerrar el body -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
</body>
</html>
<?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/quienesSomos.blade.php ENDPATH**/ ?>