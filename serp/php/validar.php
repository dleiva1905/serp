<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
require('connect2db.php');

$username=$_POST['user'];
$pass=$_POST['pass'];

$query = mysqli_query($mysqli,"SELECT * FROM empleado WHERE usuario = '$username'");

if($f = mysqli_fetch_assoc($query)){
	if($f['contrasenia'] == $pass && ($f['cargo'] == 1) ){
		$_SESSION['cedula'] = $f['cedula'];
		$_SESSION['usuario'] = $f['usuario'];
		$_SESSION['nombre'] = $f['nombre'];
		$_SESSION['apellido'] = $f['apellido'];
		$_SESSION['cargo'] = $f['cargo'];

		$hora_de_conexion = date('H:i:s', strtotime('+30 minutes'));
		$fecha_de_conexion = date('Y/m/d', strtotime('+30 minutes'));

		$registrar_log = mysqli_query($mysqli, "INSERT INTO log_login VALUES ('', '".$f['cedula']."', '7', '".$hora_de_conexion."', '', '".$fecha_de_conexion."', '')");

		echo '<script>alert("BIENVENIDO ADMINISTRADOR")</script> ';
		echo "<script>location.href='../administrador.php'</script>";
	}
}

$query = mysqli_query($mysqli,"SELECT * FROM empleado WHERE usuario = '$username'");

if($f2=mysqli_fetch_assoc($query)){
	if(($f2['contrasenia'] == $pass) && ($f2['cargo'] == 2) && ($f2['cabina'] != 0) ){
		$_SESSION['cedula'] = $f2['cedula'];
		$_SESSION['usuario'] = $f2['usuario'];
		$_SESSION['cabina'] = $f2['cabina'];
		$_SESSION['nombre'] = $f2['nombre'];
		$_SESSION['apellido'] = $f2['apellido'];
		$_SESSION['cargo'] = $f['cargo'];
		$_SESSION['impresora'] = "CABINA_".$f2['cabina'];

		echo '<script>alert("Bienvenido/a \"'.$f2['nombre'].' '.$f2['apellido'].'\" al S.E.R.P.\n\nRecuerda regalar a las personas un caluroso ¡FELIZ VIAJE!")</script>';

		$hora_de_conexion = date('H:i:s', strtotime('+30 minutes'));
		$fecha_de_conexion = date('Y/m/d', strtotime('+30 minutes'));

		$registrar_log = mysqli_query($mysqli, "INSERT INTO log_login VALUES ('', '".$f2['cedula']."', '".$f2['cabina']."', '".$hora_de_conexion."', '', '".$fecha_de_conexion."', '')");

		echo "<script>location.href='../recaudador.php'</script>";
	}elseif( ($f2['contrasenia'] == $pass) && ($f2['cargo'] == 2) && ($f2['cabina'] == 0) ){
		echo '<script>alert("USUARIO DESHABILITADO. CONTACTE CON SU SUPERIOR")</script>';

		echo "<script>location.href='../index.php'</script>";
	}
	else{
		echo '<script>alert("CONTRASEÑA INCORRECTA")</script>';

		echo "<script>location.href='../index.php'</script>";
	}
}else{

	echo '<script>alert("ESTE USUARIO NO EXISTE, PORFAVOR REGISTRESE PARA PODER INGRESAR")</script> ';

	echo "<script>location.href='../index.php'</script>";
}
?>
