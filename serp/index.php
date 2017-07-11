<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <link rel="icon" type="image/png" href="images/ticket.png" />
  <link rel="stylesheet" href="bootstrap/css/loginestilo.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
  <title>Sistema de Recaudación</title>
</head>
<body background="images/golf1.jpg" style="background-attachment: fixed; background-repeat: no-repeat; background-size: 100% 100%">
  <div></div>
  <div class="login-page">
    <div class="form">
      <h4 style="padding-top: 0; margin-top: 0">INICIAR SESIÓN</h4>
      <div style="padding-bottom: 10px"></div>
      <form action="php/validar.php" method="post" class="login-form">
        <input type="text" name="user" placeholder="Usuario" autofocus required/>
        <input type="password" name="pass" placeholder="Contraseña" required/>
        <input style="background-color: #3A9642" class="btn btn-info" type="submit" value="Conectarse">
        <p class="message">PEAJE "SANTA RITA"<br>SERVICIOS VIALES DEL ZULIA (SERVIALEZ) (G-200117877) &copy; JULIO 2017</p>
      </form>
    </div>
  </div>
  <script type="text/javascript" src="bootstrap/js/jqueryn.min.js"></script>
  <script src="bootstrap/js/index.js"></script>
</body>
</html>