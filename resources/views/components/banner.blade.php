<div class="banner">
    <video autoplay muted loop id="background-video">
        <source src="{{ asset('img/banners/banner-video.mp4') }}" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="overlay"></div>
    <div class="content">
        <h1>Fabricante de componentes electronicos de calidad</h1>
        <h3>Estamos en constante crecimiento, desarrollando en forma permanente nuevos productos y “Soluciones” habiendo abordado, con mucha fuerza en estos últimos 15 años, el terreno de la iluminación con LEDs, en especial del transporte automotor, de pasajeros y carga, ferroviario y firmes intenciones de abordar otros segmentos del mismo negocio.</h3>
        <p><a href="{{ url('/productos') }}" class="btn btn-primary">Ver productos</a></p>
    </div>
</div>

<style>
    .banner {
        position: relative;
        height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        overflow: hidden;
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
    }
    
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 0, 255, 0.12); /* Filtro violeta transparente */
        z-index: 1;
    }
    
    .content {
        position: relative;
        width: 60%;
        z-index: 2;
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
