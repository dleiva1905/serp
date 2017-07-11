<!DOCTYPE html>
<html>
<script>
  function recarga(){
    location.href=location.href
  }
  setInterval('recarga()',200000)
</script>
<head>
  <meta charset="utf-8">
  <title>Sistema de Recaudación</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="images/ticket.png" />
  <script type="text/javascript" src="bootstrap/js/jqueryn.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <link href="../css/bootstrap.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css2/botones.css">
  <link rel="stylesheet" type="text/css" href="fonts/Inconsolata-Regular.tff">

  <style type="text/css">
    a, table{
      font-family: "Palatino";
      font-size: 25;
    }

    #fondo {
      background-color: #f7f9f9;
      height:500px;
      -webkit-transition: background-color 0.5s ease-in-out;
      -moz-transition: background-color 0.5s ease-in-out;
      -o-transition: background-color 0.5s ease-in-out;
      -khtml-transition: background-color 0.5s ease-in-out;
      transition: background-color 0.5s ease-in-out;
    }
    .border { border-width: 1px; border-color: black; border-style: solid; } 

    table { border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px} 
  </style>
 
</head>

<body id="fondo" " style="padding: 0">
  <div  class="container-fluid" style="padding: 0">
    <div class="row" style="padding: 0">
      <div class="col-md-12" style="padding: 0">
        <div id="carousel-example" data-interval="5000" class="carousel slide" data-ride="carousel" style="padding: 0">
          <div class="carousel-inner">
            <div class="item active">
              <img border="1" style="width: 100%; height: 300px ; opacity: 0.8;" src="images\carrousel\sguiheneuc_contrast-iloveimg-cropped.jpg" >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <?php include( "php/menu_administrador.php"); ?>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="text-center" style="padding-bottom: 20px; border-bottom: 2px solid #c64949">ADMINISTRACIÓN DEL SISTEMA</h3>
        <div class="">
          <div style="margin-bottom: 40px" class="col-sm-6 col-md-6">
            <div class="section">
              <h4 class="text-center";">REPORTES DEL SISTEMA
                <span class="glyphicon glyphicon-list-alt"></span>
              </h4>
              <div style="margin-left: 0px;" class="lead nav nav-pills">

                <div class="radio">
                  <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#reporte_total" id="exte"><b class="oscurito"></b><strong>REPORTE TOTAL</strong></a>
                </div>

                <div class="radio">
                <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#reporte_del_dia" id="exte"><b class="oscurito"></b><strong>REPORTE DEL DIA</strong></a>
                </div>

                <div class="radio">
                  <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#reporte_de_cierres" id="exte"><b class="oscurito"></b><strong>REPORTE DE CIERRES</strong></a>
                </div>

                <div class="radio">
                  <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#reporte_de_exentos" id="exte"><b class="oscurito"></b><strong>REPORTE DE EXENTOS</strong></a>
                </div>

                <div class="radio">
                <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#reporte_de_ingresos" id="exte"><b class="oscurito"></b><strong>REPORTE DE INGRESOS</strong></a>
                </div>

                <div class="radio">
                  <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#reporte_de_exentos_total" id="exte"><b class="oscurito"></b><strong>REPORTE DE EXENTOS (TOTAL)</strong></a>
                </div>
                
                <div class="radio">
                  <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#reporte_de_tiempos_de_conexion" id="exte"><b class="oscurito"></b><strong>REPORTE DE TIEMPOS DE CONEXIÓN</strong></a>
                </div>
                <div class="radio">
                  <a  style="margin-top: 30px" class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#myModal_decantar_cierre" id="exte"><b class="oscurito"></b><strong>DECLARAR CIERRE</strong></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6">
            <div class="section" style="text-align:center;">
              <h4 >CONTROL DE USUARIOS
               <span class="glyphicon glyphicon-user"></span>
             </h4>
             <div style="margin-top: 20px; " class="nav nav-tabs">
              <div class="bor">
                <a href="registro.php" class="btn btn-default" style="width: 100%"><strong>REGISTRAR USUARIO</strong></a>
              </div>
              <div class="radio">
                <a class="btn btn-default col-sm-12 col-md-12" data-toggle="modal" data-target="#modificar_usuarios" id="exte"><b class="oscurito"></b><strong>MODIFICAR USUARIOS</strong></a>
              </div>
              <img border="4" class="border" style="width: 100%; height: 140px ;opacity: 0.8; margin-top: 20px" src="images\gobernacion.jpg" >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="">
          <div class="col-md-12">
            <div>
              <h4 class="text-center"><strong>ESTADO ACTUAL DE LAS CABINAS</strong></h4>
              <div class="row-fluid">

               <?php

               require("php/connect2db.php");

               $query_cabinas = mysqli_query($mysqli, "SELECT * FROM cabina");
               $query_empleados = mysqli_query($mysqli, "SELECT * FROM empleado WHERE ");

               echo '<table class="table table-hover"><strong>';
               echo '<thead>';
               echo '<tr>';
               echo '<td align="center"><strong>CABINA</strong></th>';
               echo '<td align="center"><strong>RECAUDADOR</strong></th>';
               echo '<td align="center"><strong>DINERO EN CABINA</strong></th>';
               echo '<td align="center"><strong>TOTAL RECAUDADO</strong></th>';
               echo '</tr>';
               echo '</thead>';
               echo '<tbody>';

               while($cabina = mysqli_fetch_array($query_cabinas)){
                if($cabina['id_cabina'] != 7 && $cabina['id_cabina'] != 0){
                  $empleado = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM empleado WHERE cabina='".$cabina['id_cabina']."'"));

                  $total_recaudado = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto) FROM registro WHERE cabina='".$cabina['id_cabina']."' AND recaudador='".$empleado['cedula']."'"));

                  echo '<tr>';
                  echo '<td align="center"><strong>'.$cabina['id_cabina'].'</strong></td>';
                  echo '<td align="center"><strong>'.$empleado['nombre'].' '.$empleado['apellido'].'</strong></td>';
                  echo '<td align="center"><strong><span></span>'.number_format($cabina['dinero_actual'], 0, ',', '.').' Bsf</strong></td>';
                  echo '<td align="center"><strong><span></span>'.number_format($total_recaudado['SUM(monto)'], 0, ',', '.').' Bsf</strong></td>';

                  echo '</tr>';
                }
              }
              echo "</table>";
              extract($_GET);

              ?>

            </div>
            <!--FIN del estado actual de las cabinas-->
          </div>
          <button class="btn btn-default col-md-12 col-sm-12 col-xs-12" onclick="javascript:window.location.reload();"><b>REFRESCAR DATOS</b></button>
        </div>


      </div>
    </div>
  </div>
</div>

<div id="modificar_usuarios" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">TABLA DE USUARIOS</h4>
      </div>
      <form method="post" action="" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/menu_modificar_usuarios.php");
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="reporte_total" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">FILTROS DEL REPORTE</h4>
      </div>
      <form method="post" action="php/reporte_total.php" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/filtro_de_reporte.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_exento" value="GENERAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="reporte_del_dia" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">FILTRO DEL REPORTE</h4>
      </div>
      <form method="post" action="php/reporte_del_dia.php" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/fecha_de_reporte.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_exento" value="GENERAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="reporte_de_exentos_total" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">FILTROS DEL REPORTE</h4>
      </div>
      <form method="post" action="php/reporte_de_exentos_total.php" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/filtro_de_reporte.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_reporte_de_exentos_total" value="GENERAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="reporte_de_ingresos" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">FILTROS DEL REPORTE</h4>
      </div>
      <form method="post" action="php/reporte_de_ingresos.php" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/filtro_de_reporte.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_reporte_ingresos" value="GENERAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="reporte_de_cierres" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">FILTROS DEL REPORTE</h4>
      </div>
      <form method="post" action="php/reporte_de_cierres.php" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/filtro_de_reporte.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_reporte_ingresos" value="GENERAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="reporte_de_exentos" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">FILTROS DEL REPORTE</h4>
      </div>
      <form method="post" action="php/reporte_de_exentos.php" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/filtro_de_reporte.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_reporte_de_exentos" value="GENERAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="reporte_de_tiempos_de_conexion" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">FILTROS DEL REPORTE</h4>
      </div>
      <form method="post" action="php/reporte_de_tiempos_de_conexion.php" target="_blank" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/filtro_de_reporte.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_reporte_de_exentos" value="GENERAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>

</div>
<div id="myModal_decantar_cierre" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="text-center modal-title">DECANTAR CIERRE</h4>
      </div>
      <form method="post" action="php/registrar_decantacion.php" class="formulario" >
        <div class="modal-body">
          <?php
          include("php/decantar_cierre.php");
          ?>
        </div>
        <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="generar_decantacion" value="DECLARAR">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        </div>
      </form>
    </div>
  </div>
</div>
<style type="text/css">
  footer{
    text-align:center;
    border-top: 2px solid red;
    font-size: 13px;
    margin-top: 50px;
  }
</style>
<footer>
  <p>GOBERNACIÓN BOLIVARIANA DEL ZULIA - SERVICIOS VIALES DEL ZULIA (SERVIALEZ) (G-200117877) &copy; JULIO 2017</p>
</footer>
<div class="clearfix"></div>
</body>
</html>