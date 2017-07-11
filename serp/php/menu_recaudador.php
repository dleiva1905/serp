<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <link rel="icon" type="image/png" href="../images/ticket.png" />
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
      margin-left: 100px ; text-align: center;margin-bottom: 10px;
    }
  }

  #frase{
    font-family: "Palatino";
    font-size: 20px;
  }

</style>
<body onload="javascript:frase()">
  <script language="Javascript">
    function getRandomArbitrary(min, max) {
      return Math.random() * (max - min) + min;
    }

    function generarCierre(){
      $.ajax({
        type: 'POST',
        url: 'php/generar_e_imprimir_cierre.php',
        success: function(response) {
          window.location.reload(),
          $('myModal').modal('hide');
        }
      });
    }

    function frase() {
      frases = 
      ['"Hazlo, o no lo hagas, pero no lo intentes" - Yoda (Star Wars)',
      'Recuerda regalar a las personas un caluroso ¡FELIZ VIAJE!',
      '"El éxito es la suma de pequeños esfuerzos repetidos un día sí y otro también" - Robert Collier',
      '"El triunfo no está en vencer siempre, sino en nunca desanimarse" - Napoleón Bonaparte',
      '"Debes estar contento de contar con el sustento de tu trabajo, pues este les asegurará un buen futuro a tu familia y a ti"',
      '"Ten presente que el éxito yace en el esfuerzo que dediques a tu trabajo, sólo esforzándote obtendrás cosas maravillosas"',
      '"Trabajando aprendemos muchas cosas, entre las ventajas que esto trae encontramos la oportunidad de ser responsables y comprometernos con nuestras metas y objetivos"',
      '"Así como los atletas dan todo de sí en sus entrenamientos para conseguir medallas, los trabajadores que trabajan con todo su esfuerzo obtienen ascensos"',
      '"Sumergiéndote en tu trabajo podrás distraerte de las cosas que te sucedan en tu vida"',
      '"A través de tu arduo trabajo, no solo obtendrás dinero, sino que, también, aprenderás nuevas cosas cada día"'];

      document.getElementById("frase").textContent=frases[Math.round(Math.random()*10)];

      return false;
    }

    setInterval('frase()', 20000);

  </script>
  <center>
    <div class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-left botonm">
              <li class="sobre">
                <a class="" data-toggle="modal" data-target="#myModal" href="">GENERAR CIERRE<span class="glyphicon glyphicon-list-alt"></span></a>
              </li>

              <li class="sobre">
                <a href="php/verificar_estado.php" class="">CERRAR SESIÓN<span class="glyphicon glyphicon-log-out"></span></a>
              </li>
            </ul>
            <br>
            <center>
              <ul style="margin-left: 45%;" class="nav navbar-left">
                <li style="" class="text-center">
                  <p style="color: black;font-size: 18px;">BIENVENIDO OPERADOR: <em><strong><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'];?></strong></em></p></a>
                </li>
              </ul>
              <br>
            </center>
          </div>
        </div>
      </div>
    </div>
  </center>
  <center>
  <span id="frase" style="margin: 0; padding: 0"></span>
  </center><br>
  <div style="margin-bottom: 0px;"></div>
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="text-center modal-title">CIERRE A GENERAR</h4>
        </div>
        <div class="modal-body" id="ticket_cierre">
          <?php
          include("generar_cierre.php");
          ?>
        </div>
        <div class="modal-footer">
          <form>
            <button type="button" class="btn btn-default" onclick="javascript:generarCierre()">GENERAR</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
