<?php
session_start();
$cabina = $_SESSION['cabina'];
$recaudador = $_SESSION['cedula'];
$tipo_de_vehiculo = $_POST['valor'];
$impresora = $_SESSION['impresora'];

header("Content-Type: text/html;charset=utf-8;");

require("connect2db.php");

$query_empleados = mysqli_query($mysqli,"SELECT * FROM empleado WHERE cabina='$cabina'");

$query_cabinas = mysqli_query($mysqli, "SELECT * FROM cabina WHERE id_cabina='$cabina';");

$query_tabulador = mysqli_query($mysqli, "SELECT * FROM tabulador WHERE id_tabulador='$tipo_de_vehiculo';");

while($datos_cabina=mysqli_fetch_array($query_cabinas)){
  $id_cabina = $datos_cabina['id_cabina'];
}
while($datos_tabulador=mysqli_fetch_array($query_tabulador)){
  $monto = $datos_tabulador['tarifa'];
  $vehiculo = $datos_tabulador['tipo_de_vehiculo'];
}

$datos_empleado = mysqli_fetch_assoc($query_empleados);

$fecha = date('d/m/Y', strtotime('+30 minutes'));
$hora = date('H:i A', strtotime('+30 minutes'));

$fecha2 = date('Y/m/d', strtotime('+30 minutes'));
$hora2 = date('H:i:s', strtotime('+30 minutes'));

$cedula_empleado = $datos_empleado['cedula'];
$nombre_completo_empleado = $datos_empleado['nombre'].' '.$datos_empleado['apellido'];

$query_registro = "INSERT INTO registro VALUES ('', '$tipo_de_vehiculo', '$cedula_empleado', '$cabina', '$monto', '$fecha2', '$hora2');";

$query_update = "UPDATE cabina SET dinero_actual=dinero_actual+'$monto' WHERE id_cabina='$cabina';";

$query_registro_id = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(id_registro) FROM registro;"));
$numero_de_registro = $query_registro_id['MAX(id_registro)'];

mysqli_query($mysqli,$query_registro);

mysqli_query($mysqli,$query_update);


function formato($c) { 
  printf("%07d",  $c); 
}

require __DIR__ . '/../lib/escpos/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
try {
  $connector = new CupsPrintConnector($impresora);

  /* Print a "Hello world" receipt" */
  $printer = new Printer($connector);

  $printer -> setJustification(Printer::JUSTIFY_CENTER);

  $cabecera1 = "GOBIERNO BOLIVARIANO DE VENEZUELA\n"."GOBERNACIÓN BOLIVARIANA DEL ZULIA\n"."SERVIALEZ (G-200117877)\n";

  $cabecera2 = "PEAJE \"SANTA RITA\""."\n"."RECIBO DE PAGO #".$numero_de_registro."\n";

  $datos_1 = "     EMITIDO : ".$fecha." - ".$hora."\n";
  $datos_2 = "     OPERADOR: ".$nombre_completo_empleado." (TAQUILLA #".$cabina.")"."\n";
  $datos_3 = $vehiculo." - ".$monto." Bsf"."\n";

  $printer -> setTextSize(1, 1);

  $printer -> text($cabecera1);
  $printer -> text($cabecera2);
  $printer -> feed();

  $printer -> setJustification(Printer::JUSTIFY_LEFT);

  $printer -> text($datos_1);

  $printer -> text($datos_2);

  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> setEmphasis(true);
  $printer -> text($datos_3);
  $printer -> setEmphasis(false);

  $printer -> feed();

  $pie_1 = "¡GOBERNAR ES HACER! - FELIZ VIAJE.\n";
  $pie_2 = "TELEFÓNO DE AUXILIO VIAL         : 0426-5620419\n";
  $pie_3 = "TELEFÓNO DE RECLAMOS Y SUGERENCIA: 0426-5620408\n";

  $printer -> text($pie_1);
  $printer -> text($pie_2);
  $printer -> text($pie_3);

  $printer -> cut();

  $printer -> pulse();
  /* Close printer */
  $printer -> close();
} catch (Exception $e) {
  echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

header("Location: ../recaudador.php");
?>
