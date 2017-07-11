<?php

echo $nombre = $_POST['nombre'];
echo $apellido = $_POST['apellido'];
echo $cedula = $_POST['cedula'];
echo $usuario = $_POST['user'];
echo $contrasenia = $_POST['pass'];

date_default_timezone_set('America/Caracas');

require("connect2db.php");

$query_usuario = mysqli_query($mysqli,"SELECT usuario FROM empleado WHERE usuario='$usuario';");

if(mysqli_num_rows($query_usuario)>0){
	echo '<script language="javascript">alert("Nombre de usuario ya se encuentra registrado.");</script>';
	echo "<script>location.href='../registro.php'</script>";
}
else{
	$query_cedula = mysqli_query($mysqli,"SELECT cedula FROM empleado WHERE cedula='$cedula';");
	if(mysqli_num_rows($query_cedula)>0) {

		echo '<script language="javascript">alert("Cedula ya se encuentra registrada.");</script>';
		echo "<script>location.href='../registro.php'</script>";
	}
	else{
		$registro = mysqli_query($mysqli, "INSERT INTO empleado VALUES ('$cedula', '$nombre', '$apellido', '$usuario', '$contrasenia', '2', '0');");

		echo '<script language="javascript">alert("¡Usuario registrado con exito!");</script>';
		echo "<script>location.href='../administrador.php'</script>";
	}
}

echo "<script>location.href='../administrador.php'</script>";

?>
