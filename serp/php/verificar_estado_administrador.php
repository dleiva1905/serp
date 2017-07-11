<?php
session_start();

$recaudador=$_SESSION['cedula'];

require("connect2db.php");

$completar_log = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT MAX(id_log_login) FROM log_login WHERE usuario='$recaudador' AND fecha_de_desconexion='' AND hora_de_desconexion=''"));

$maximo_id = $completar_log['MAX(id_log_login)'];

$fecha_de_desconexion = date('Y/m/d', strtotime('+30 minutes'));
$hora_de_desconexion = date('H:i:s', strtotime('+30 minutes'));

mysqli_query($mysqli, "UPDATE log_login SET fecha_de_desconexion='$fecha_de_desconexion', hora_de_desconexion='$hora_de_desconexion' WHERE id_log_login='$maximo_id' AND fecha_de_desconexion='' AND hora_de_desconexion='' AND usuario='$recaudador'");

header("Location: desconectar.php");
?>