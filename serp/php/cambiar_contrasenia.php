<!DOCTYPE html>
<?php
session_start();
$cedula = $_GET['id'];
if (@!$_SESSION['usuario']) {
  header("Location: ../index.php");
}
?>
<html>
<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="../images/ticket.png" />
  <link rel="stylesheet" href="../bootstrap/css/loginestilo.css">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css" />
  <title>Sistema de Recaudación</title>
</head>
<body background="../images/golf1.jpg" style="background-attachment: fixed; background-repeat: no-repeat; background-size: 100% 100%">
  <div></div>
  <div class="login-page">
    <div class="form">
      <h4>CAMBIAR CONTRASEÑA</h4>
      <div style="padding-bottom: 20px;"></div>
      <form method="post" action="actualizar.php" class="formulario" >

        <input type="password" name="contrasenia_original" placeholder="Contrasenia Actual" required/>

        <input type="password" name="contrasenia_nueva" placeholder="Nueva Contraseña" required/>
        <input type="password" name="contrasenia_nueva_ver" placeholder="Verificar nueva contraseña" required/>

        <input id="ejec" style="background-color: #3a9642" class="btn btn-danger" type="submit" name="submit" value="ASIGNAR CABINA"/>
        <input type="hidden"  name="cedula" value="<?php echo $cedula; ?>" >
      </form>
    </div>
  </div>
  <script type="text/javascript" src="bootstrap/js/jqueryn.min.js"></script>
  <script src="bootstrap/js/index.js"></script>
</body>
</html>