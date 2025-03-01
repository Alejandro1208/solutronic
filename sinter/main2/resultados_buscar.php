<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="estilos.css"> 
	<link rel="stylesheet" href="css/lightbox.min.css">
<meta charset="utf-8">
<title>Obras</title>
</head>

<body>

<header>
	 
	    <a href="javascript:void(0);" class="icono" onclick="myFunction()"><i class="fa fa-bars"></i></a>
	<a href="index.html"><img class="logo" src="images/Logoc.png"  ></a>
        <nav id="mibarra" class=" ">
			
         <a href="Constructivismo.html">Constructivismo</a>
		<a href="Artistas.html">Artistas</a>
		<a href="Obras.html" class="selec">Obras</a>
		<a href="Eventos.html">Eventos</a>
		<a href="Espacios.html">Espacios</a>
		<a href="contacto.html">Contacto</a>
		<a class="sesionnav" href="login.html">Iniciar Sesion</a>    

	
			
        </nav>
	
</header>
<section>
	<br>

<?php
	include('conexion1.php');

	$buscar = $_POST['buscar'];
	echo "Su consulta: <em>".$buscar."</em><br>";

	$consulta = mysqli_query($conexion, "SELECT * FROM obras WHERE nombre LIKE '%$buscar%' OR autor LIKE '%$buscar%' ");
?>
<article >
	<p>Cantidad de Resultados: 
	<?php
		$nros=mysqli_num_rows($consulta);
		echo $nros;
	?>
	</p>
    
	<?php
		while($resultados=mysqli_fetch_array($consulta)) {
	?>
    <p>
    <?php	
			echo $resultados['nombre'] . " ";
			?>
			<br>
			<?php
			echo $resultados['autor'] . " ";
			?>
			<br>
			
			<div style="background-color:#dfdede" class="cajagaleria">	
				<div>	
	<img src="<?php echo $resultados ['imagen'];?>">
	</div>
	
	</div>
    </p>
    <hr/>
    <?php
		}

		mysqli_free_result($consulta);
		mysqli_close($conexion);

	?>
</article>
</section>

</body>
</html>