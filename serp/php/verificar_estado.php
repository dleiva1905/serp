<?php
session_start();
$cabina=$_SESSION['cabina'];
$recaudador=$_SESSION['cedula'];
$impresora = $_SESSION['impresora'];

require("connect2db.php");
require __DIR__ . '/../lib/escpos/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;

$query_empleados = mysqli_query($mysqli,"SELECT * FROM empleado WHERE cabina='$cabina'");

$query_cabinas = mysqli_query($mysqli, "SELECT * FROM cabina WHERE id_cabina='$cabina';");

$query_ultimo_cierre_id = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(id_cierre) FROM cierre;"));

while($datos_cabina=mysqli_fetch_array($query_cabinas)){
 $id_cabina = $datos_cabina[0];
 $dinero_recaudado = $datos_cabina[1];
}
 
if($dinero_recaudado > 0){
 echo '<script>alert("AÚN HAY DINERO EN CAJA, SE GENERARÁ UN CIERRE AUTOMÁTICO.")</script>';

 $datos_empleado = mysqli_fetch_assoc($query_empleados);

 $fecha = date('d/m/Y', strtotime('+30 minutes'));
 $hora = $hora = date('H:i A', strtotime('+30 minutes'));

 $fecha2 = date('Y/m/d', strtotime('+30 minutes'));
 $hora2 = date('H:i:s', strtotime('+30 minutes'));

 $nombre_completo_empleado = $datos_empleado['nombre'].' '.$datos_empleado['apellido'];

 $id_ultimo_cierre = $query_ultimo_cierre_id['MAX(id_cierre)'];

 $registro = mysqli_query($mysqli, "INSERT INTO cierre VALUES ('', '$recaudador', '$cabina', '$fecha2', '$hora2', '$dinero_recaudado');");

 $reinicio = mysqli_query($mysqli, "UPDATE cabina SET dinero_actual = '0' WHERE id_cabina='$cabina'");

 try {
  if(is_null($id_ultimo_cierre)){
    $id_ultimo_cierre = 1;
  }

  $connector = new CupsPrintConnector($impresora);

  /* Print a "Hello world" receipt" */
  $printer = new Printer($connector);
  $printer -> setJustification(Printer::JUSTIFY_CENTER);

  $cabecera1 = "SISTEMA ESPECIALIZADO DE RECAUDACIÓN DE PEAJES\n"."(S.E.R.P)\n";

  $printer -> text($cabecera1);
  $datos_1 = "CIERRE DE CAJA #".$id_ultimo_cierre."\n";
  $printer -> feed();

  $datos_2 = "EMITIDO        : ".$fecha." - ".$hora."\n";
  $datos_3 = "RECAUDADOR     : ".$nombre_completo_empleado." (TAQUILLA #".$cabina.")\n";
  $datos_4 = "MONTO RECAUDADO: ".$dinero_recaudado." Bsf\n";

  $printer -> text($datos_1);

  $printer -> setJustification(Printer::JUSTIFY_LEFT);
  $printer -> text($datos_2);
  $printer -> text($datos_3);
  $printer -> text($datos_4);
  $printer -> feed();

  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("CIERRE AUTOMÁTICO GENERADO POR DESCONEXIÓN\n");

  $printer -> cut();

  $printer -> pulse();
  /* Close printer */
  $printer -> close();
} catch (Exception $e) {
 echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
}

mysqli_query($mysqli, "UPDATE empleado SET cabina='0' WHERE cedula='$recaudador'");

$completar_log = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT MAX(id_log_login) FROM log_login WHERE usuario='$recaudador' AND fecha_de_desconexion='' AND hora_de_desconexion=''"));

$maximo_id = $completar_log['MAX(id_log_login)'];

$fecha_de_desconexion = date('Y/m/d', strtotime('+30 minutes'));
$hora_de_desconexion = date('H:i:s', strtotime('+30 minutes'));

mysqli_query($mysqli, "UPDATE log_login SET fecha_de_desconexion='$fecha_de_desconexion', hora_de_desconexion='$hora_de_desconexion' WHERE id_log_login='$maximo_id' AND fecha_de_desconexion='' AND hora_de_desconexion='' AND usuario='$recaudador'");

header("Location: desconectar.php");
?>
