<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login de Usuarios</title>
</head>

<body>

<?php
$usuario=$_POST['usuario'];
$password=$_POST['password'];

include("conexion.php");

$consulta=mysqli_query($conexion, "SELECT nombre, apellido, email FROM usuarios WHERE usuario='$usuario' AND password='$password'");

$resultado=mysqli_num_rows($consulta);

if($resultado!=0){
	$respuesta=mysqli_fetch_array($consulta);
	
	$_SESSION['nombre']=$respuesta['nombre'];
	$_SESSION['apellido']=$respuesta['apellido'];
		
		echo "Hola ".$_SESSION['nombre']." ".$_SESSION['apellido']."<br />";
		echo "Acceso al panel de usuarios.<br/>";
		echo "<a href='obras2.php'>Ingresar</a>";	

}else{
	echo "No es un usuario registrado";
	include ("form_registro.html");
}








?>

</body>
</html>