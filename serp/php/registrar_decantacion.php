<?php
session_start();
$administrador=$_SESSION['cedula'];

$cierre = $_POST['cierre'];
$monto = $_POST['monto'];

require("connect2db.php");

$fecha = date('Y/m/d', strtotime('+30 minutes'));
$hora = date('H:i:s', strtotime('+30 minutes'));

if(mysqli_query($mysqli, "INSERT INTO decantacion VALUES ('', '$cierre', '$monto', '$fecha', '$hora')")){
  echo '<script>alert("!DECLARACIÓN REALIZADA CON EXITO!")</script>';

  echo "<script>location.href='../administrador.php'</script>";
}
else{
  echo '<script>alert("CIERRE DECANTADO ANTERIORMENTE")</script>';

  echo "<script>location.href='../administrador.php'</script>";
}

?>