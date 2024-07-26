<div class="container quienes-somos my-5 shadow">
    <div class="row align-items-center">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-6 copys">
            <h2 class="display-4">Quiénes somos</h2>
            <p class="lead">Solutronic es un emprendimiento destinado a aportar soluciones electrónicas tendientes a facilitar el trabajo, resolver necesidades en distintos ámbitos desarrollando productos confiables, y al mismo tiempo reconozcan un costo razonable.</p>
        </div>
    </div>
  </div>
  <style scoped>
      .quienes-somos {
          background-image: url('img/banners/foto.png');
          background-color: rgba(0, 0, 0, 0.7);
          background-position: center;
          border-radius: 12px;
          width: 100vw;
          height: 50vh;
          position: relative;
          -webkit-box-shadow: 11px 10px 5px 0px rgba(133,131,133,0.45)!important;
            -moz-box-shadow: 11px 10px 5px 0px rgba(133,131,133,0.45)!important;
            box-shadow: 11px 10px 5px 0px rgba(133,131,133,0.45)!important;       
      }
      .quienes-somos::before{
        border-radius: 12px;
        content:'';
	    position: absolute;
        top: 0;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    background-color: rgba(0,0,0,0.3);
      }
      .quienes-somos .copys{
        position: absolute;
        background-color: rgba(97, 34, 104, 0.882);
        border-radius: 15px;
        color: #f0f0f0;
        border: solid 2px rgb(97, 34, 104, 0.882);
        bottom: 40px;
        right: 10px;
      }

      @media only screen and (max-width: 600px){
        .quienes-somos {
          background-image: url('img/fondo-qs.png');
          background-color: rgba(0, 0, 0, 0.7);
          background-position: center;
          border-radius: 12px;
          width: 90vw;
          height: 50vh;
          position: relative;
          -webkit-box-shadow: 11px 10px 5px 0px rgba(133,131,133,0.45)!important;
            -moz-box-shadow: 11px 10px 5px 0px rgba(133,131,133,0.45)!important;
            box-shadow: 11px 10px 5px 0px rgba(133,131,133,0.45)!important;       
      }
      .quienes-somos::before{
        border-radius: 12px;
        content:'';
	    position: absolute;
        top: 0;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    background-color: rgba(0,0,0,0.3);
      }
      .quienes-somos .copys{
        position: absolute;
        background-color: rgba(97, 34, 104, 0.882);
        border-radius: 15px;
        color: #f0f0f0;
        border: solid 2px rgb(97, 34, 104, 0.882);
        bottom: 130px;
        left: 50%;
        transform: translate(-50%, 50%);
        width: 90%;
      }
      .copys h2{
        font-size: 40px
      }
      .copys p{
        font-size: 16px
      }
      }
  </style>