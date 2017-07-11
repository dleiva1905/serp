<?php
$cabina=$_SESSION['cabina'];
$recaudador=$_SESSION['cedula'];

require("connect2db.php");

$query_empleados = mysqli_query($mysqli,"SELECT * FROM empleado WHERE cabina='$cabina'");

$query_cabinas = mysqli_query($mysqli, "SELECT * FROM cabina WHERE id_cabina='$cabina';");

$query_ultimo_cierre_id = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(id_cierre) FROM cierre;"));

while($datos_cabina=mysqli_fetch_array($query_cabinas)){
  $id_cabina = $datos_cabina[0];
  $dinero_recaudado = $datos_cabina[1];
}

if($dinero_recaudado >= 70000){
  $datos_empleado = mysqli_fetch_assoc($query_empleados);

  $fecha = date('d/m/Y', strtotime('+30 minutes'));
  $hora = date('H:i:s', strtotime('+30 minutes'));

  $nombre_completo_empleado = $datos_empleado['nombre'].$datos_empleado['apellido'];
  $cedula_empleado = $datos_empleado['cedula'];

  $id_ultimo_cierre = $query_ultimo_cierre_id['MAX(id_cierre)'] + 1;
  ?>
  <html>
  <head>
   <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <link rel="icon" type="image/png" href="../images/ticket.png" />
   <style type="text/css" media="print">
    @page {
     margin: 0cm;
     padding-top: 0cm; 
   }
 </style>
</head>
<body">
<div id="ticket">
  <center><p><strong><small>
    <br>CIERRE # <?php echo formato($id_ultimo_cierre) ?>
    <br>FECHA: <?php echo $fecha; ?>
    <br>HORA: <?php echo $hora; ?>
    <br>RECAUDADOR: <?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?>
    <br>MONTO RECAUDADO: <?php echo $dinero_recaudado;?> Bsf
  </small></strong></p></center></strong>
</div>
</body>
</html> 

<?php

}
else{
  echo 'No hay suficiente dinero para ejecutar el cierre!';
}

function formato($c) { 
  printf("%07d",  $c); 
}

?>