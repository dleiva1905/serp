<?php
session_start();
$cabina=$_SESSION['cabina'];
$recaudador=$_SESSION['cedula'];
$tipo_de_exento = $_POST['tipo_de_exento'];
$placa = $_POST['placa'];

require("connect2db.php");

$query_exentos = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM exento WHERE id_exento='$tipo_de_exento'"));

$query_empleados = mysqli_query($mysqli,"SELECT * FROM empleado WHERE cabina='$cabina'");

$datos_empleado = mysqli_fetch_assoc($query_empleados);

$fecha = date('Y/m/d', strtotime('+30 minutes'));
$hora = date('H:i:s', strtotime('+30 minutes'));

$nombre_completo_empleado = $datos_empleado['nombre'].$datos_empleado['apellido'];
$cedula_empleado = $datos_empleado['cedula'];

$monto = $query_exentos['monto_no_percibido'];

$registrar_exento = mysqli_query($mysqli, "INSERT INTO registro_exento VALUES ('', '$tipo_de_exento', '$placa', '$cedula_empleado', '$cabina', '$fecha', '$hora', '$monto');");

header("Location:../recaudador.php")
?>