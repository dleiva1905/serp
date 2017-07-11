<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="bootstrap/css/loginestilo.css">
  <link rel="icon" type="image/png" href="images/ticket.png" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
  <title>Sistema de Recaudación</title>
</head>
<body background="images/golf1.jpg" style="background-attachment: fixed; background-repeat: no-repeat; background-size: 100% 100%">
  <div></div>
  <div class="login-page">
    <div class="form">
      <h4>REGISTRO DE USUARIOS</h4>

      <div style="padding-bottom: 20px;"></div>
      <form method="post" action="php/registrar_usuario.php" class="formulario" >
        <input type="text" name="nombre" placeholder="Nombre" required/>
        <input type="text" name="apellido" placeholder="Apellido"/>
        <input type="text" name="cedula" placeholder="Cedula de identidad" required minlength="7" maxlength="8" />
        <input type="text" name="user" placeholder="Nombre de usuario" required maxlength="10" />
        <input type="password" name="pass" placeholder="Contraseña" required/>
        <input id="ejec" style="background-color: #3a9642" class="btn btn-danger" type="submit" name="submit" value="REGISTRAR USUARIO"/>
      </form>
    </div>
  </div>
  <script type="text/javascript" src="bootstrap/js/jqueryn.min.js"></script>
  <script src="bootstrap/js/index.js"></script>
</body>
</html>