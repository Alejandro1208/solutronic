<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<div class="banner">
            <video autoplay="" muted="" loop="" id="background-video">
                <source src="https://www.solutronic.com.ar/img/banners/banner-video.mp4" type="video/mp4">
            </video>
            <div class="overlay"></div>
            <div class="content" style="
    margin-top: 2%;
">
                <h1>Soluciones electrónicas de calidad</h1>
                <h3 style="
    
    margin-bottom: -1rem;
    max-width: 890px;

">Estamos en constante crecimiento, desarrollando en forma permanente nuevos productos y Soluciones, habiendo abordado con mucha fuerza en estos últimos 20 años el terreno de la iluminación con LEDs, en especial del transporte automotor tanto de pasajeros como de carga, también en el sector ferroviario y con intenciones de abordar otros sectores del mercado.</h3>
                <br>
                <br>
                <form id="search-form" action="<?php echo e(route('productos.index')); ?>" method="GET" class="d-flex m-4" style="
    justify-content: center;
    text-align: center;
">
    <input type="text" name="search" class="form-control me-2" style="
    border-color: #0000008f;border-radius: 15px;
" placeholder="Buscar productos..." required>
    <button id="search-btn" class="btn btn-outline-success" type="submit" style="
    background-color: #000000a1;
    color: white;
    border-color: black;
    border-radius: 0px 15px 15px 0px;
">Buscar</button>
</form>
           <p id="show-map-link" style="cursor: pointer; text-decoration: none; margin-top: 4%; display: flex; align-items: center; gap: 0.5rem;justify-content: center;">
    Conoce Nuestra Red de Distribución 
    <i class="fas fa-map-marked-alt" ></i>
</p>
    </div>
</div>

<!-- Mapa flotante -->
<div id="map-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="position: relative; width: 80%; height: 80%; background: white; border-radius: 10px; overflow: hidden;">
        <button id="close-map" style="position: absolute; top: 8px; left: 12px; background: red; color: white; border: none; padding: 10px; border-radius: 10%; cursor: pointer; z-index: 1001;">&times;</button>
        <iframe src="https://www.google.com/maps/d/embed?mid=1DK9M40rpk5twtn6jmsuubzOr-ULh7c8j&ehbc=2E312F" width="100%" height="100%" style="border: none;"></iframe>
    </div>
</div>

    <style>
    .banner {
        position: relative;
        height: 85vh;
        width:100%;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        overflow: hidden;
    }
     .show-map-link:hover {
        color: blue;
    }
    #show-map-link:hover {
        color: #0056b3;
    }

    #map-modal iframe {
        width: 100%;
        height: 100%;
    }
    .form-control {
        width:80%;
        background-color:#fdfdfd69;
        
    }
    .me-2 {
    margin-right: -4.5rem !important;
}
    
    #background-video {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        object-fit: cover;
        filter: blur(4px);
    }
    
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 60%); /* Filtro negro transparente */
        z-index: 1;
    }
    
    .content {
        position: relative;
        width: 60%;
        z-index: 2;
        max-width: 900px;
    }
    
    h1 {
        font-size: 3.5em;
        margin-bottom: 0.5em;
    }
    
    h3 {
        font-size: 1em;
        margin-bottom: 1em;
    }
    
    .btn-primary {
        font-size: 20px;
        padding: 10px 25px;
        background-color: #FF00FF !important;
        border-radius: 28px;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #ca00ca !important;
    }
    
    @media (max-width: 767.98px) {
        .content {
        position: relative;
        width: 90%;
        z-index: 2;
    }
        .banner {
            height: 70vh;
        }
    
        h1 {
            font-size: 2.3em;
        }
    
        h3 {
            font-size: .8em;
        }
    }
    </style>
    <script>
    document.getElementById('show-map-link').addEventListener('click', function() {
        document.getElementById('map-modal').style.display = 'flex';
    });

    document.getElementById('close-map').addEventListener('click', function() {
        document.getElementById('map-modal').style.display = 'none';
    });
</script>
<?php /**PATH /home/u984597834/domains/solutronic.com.ar/resources/views/components/banner.blade.php ENDPATH**/ ?>