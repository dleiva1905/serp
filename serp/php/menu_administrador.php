<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['usuario']) {
  header("Location:index.php");
}
$usuario = $_SESSION['usuario'];
require("connect2db.php");
$query_nombre = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT nombre, apellido FROM empleado WHERE usuario= '$usuario';"));
$nombre=$query_nombre['nombre'];
$apellido=$query_nombre['apellido'];

?>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <link rel="icon" type="image/png" href="../images/ticket.png" />
  <link href="css/bootstrap.css" rel="stylesheet">

</head>
<style type="text/css">

  .sobre a{
   color:#fff !important;
   width: 300px;
   font-weight: bold;
 }

 .sobre span{
   font-size: 25px;
   margin-left: 10px;
 }
 .navbar-nav{
   background: #c64949 !important;
   border-radius: 5px;
 }

 .sobre:hover{
   transition: 0.5s;
   background: #892626 !important;
   border-radius: 5px;
 }

 .navbar-default{
   background: none !important;
   border: none !important;
 }
 .botonm{
   margin-left: 250px ;
   text-align: center;
   margin-bottom: 10px;
 }

 @media (max-width:1000px) {
   .sobre a{
     color:#fff !important;
     width: 200px;
     font-weight: bold;
   }

   .sobre span{
     font-size: 25px;
     margin-left: 10%;
   }
   .navbar-nav{
     background: #c64949 !important;
     border-radius: 5px;
   }

   .sobre:hover{
     transition: 0.5s;
     background: #892626 !important;
     border-radius: 5px;
   }

   .navbar-default{
     background: none !important;
     border: none !important;
   }

   .botonm{
     margin-left: 55% ; text-align: center;margin-bottom: 0px;
   }
 }

</style>
<div class="navbar navbar-default navbar-static-top" align="middle">
  <div class="container">
    <div class="navbar-header">
      <div class="collapse navbar-collapse" id="navbar-ex-collapse">
        <ul class="nav navbar-nav navbar-left botonm">
          <li class="sobre">
            <a href="administrador.php">ADMINISTRACIÓN<span class="glyphicon glyphicon-list-alt"></span></a>
          </li>

          <li class="sobre">
            <a href="php/verificar_estado_administrador.php" class="">CERRAR SESIÓN<span class="glyphicon glyphicon-log-out"></span></a>
          </li>
        </ul>

        <ul style="margin-left: 45%;" class="nav navbar-left">
          <li><a class="text-center" href="" style="color: black">BIENVENIDO: <strong><?php echo $nombre.' '.$apellido;?></strong> </a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
</html>
