<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['usuario']) {
  header("Location:index.php");
}
?>
<script>
  function recarga(){
    location.href=location.href
  }
  setInterval('recarga()',200000)
  }
</script>
<html lang="es">
<head>
  <title>Sistema de Recaudación</title>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/ticket.png" />
  <script type="text/javascript" src="bootstrap/js/jqueryn.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="css/sty.css">

  <style type="text/css">
    body,a, #vehiculos{
      font-family: "Palatino";
      font-size: 20px;
    }

    #vehiculos{
      font-family: "Palatino";
      font-size: 20px;
    }

    label {
      font-size:
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
              <img border="1" style="width: 100%; height: 300px ;opacity: 0.8;" src="images\carrousel\sguiheneuc_contrast-iloveimg-cropped.jpg" >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid" style="">
    <div class="row">
      <div class="col-md-12">
        <?php include( "php/menu_recaudador.php"); ?>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div align='center' >
          <form method="post" action="php/generar_ticket.php" class="formulario" >
            <div class="col-sm-6 col-md-6">
              <h4 class="text-center"><strong>TABULADOR DE VEHÍCULOS</strong></h4>
              <ul class="nav nav-stacked">
                <div class="col-sm-6 col-md-6">
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="puesto" value="1" onclick="changeImage('images/vehiculos/1.png', 'VEHÍCULOS POR PUESTO - 50 Bsf.', this.form)">
                      <label id="vehiculos" for="puesto">1: VEHÍCULOS POR PUESTO</label>
                    </div>
                  </li>
                  <br>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="moto" value="2" onclick="changeImage('images/vehiculos/2.png', 'MOTOS A PARTIR DE 500CC - 100 Bsf.', this.form)">
                      <label id="vehiculos" for="moto">2: MOTOS A PARTIR DE 500CC</label>
                    </div>
                  </li><br>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="liv" value="3" onclick="changeImage('images/vehiculos/3.png', 'VEHÍCULOS LIVIANOS Y MICROBUSES - 100 Bsf.', this.form)">
                      <label id="vehiculos" for="liv">3: VEHÍCULOS LIVIANOS Y MICROBUSES</label>
                    </div>
                  </li><br>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="taxi" value="4" onclick="changeImage('images/vehiculos/4.png', 'TAXIS - 100 Bsf.', this.form)">
                      <label id="vehiculos" for="taxi">4: TAXIS</label>
                    </div><br>
                  </li>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="buses" value="5" onclick="changeImage('images/vehiculos/5.png', 'BUSES COLECTIVOS - 300 Bsf.', this.form)">
                      <label id="vehiculos" for="buses">5: BUSES COLECTIVOS</label>
                    </div><br>
                  </li>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="camion" value="6" onclick="changeImage('images/vehiculos/6.png', 'CAMIÓN 350 (2 EJES) - 500 Bsf.', this.form)">
                      <label id="vehiculos" for="camion">6: CAMIÓN 350 (2 EJES)</label>
                    </div><br>
                  </li>
                </div>
                <div class="col-sm-6 col-md-6">
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="750" value="7" onclick="changeImage('images/vehiculos/7.png', 'CAMIÓN 750 - 600 Bsf.', this.form)">
                      <label id="vehiculos" for="750">7: CAMIÓN 750</label>
                    </div><br>
                  </li>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="expres" value="8" onclick="changeImage('images/vehiculos/8.png', 'BUSES EXRESOS - 1000 Bsf.', this.form)">
                      <label id="vehiculos" for="expres">8: BUSES EXPRESOS</label>
                    </div><br>
                  </li>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="3ejes" value="9" onclick="changeImage('images/vehiculos/9.png', 'VEHÍCULOS PESADOS (3 EJES) - 1000 Bsf.', this.form)">
                      <label id="vehiculos" for="3ejes">9: VEHÍCULOS PESADOS (3 EJES)</label>
                    </div><br>
                  </li>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="4ejes" value="10" onclick="changeImage('images/vehiculos/10.png', 'VEHÍCULOS PESADOS (4 EJES) - 1500 Bsf.', this.form)">
                      <label id="vehiculos" for="4ejes">A: VEHÍCULOS PESADOS (4 EJES)</label>
                    </div><br>
                  </li>
                  <li class="active">
                    <div class="radio">
                      <input type="radio" name="valor" id="5ejes" value="11" onclick="changeImage('images/vehiculos/11.png', 'VEHÍCULOS PESADOS (5 EJES O MÁS) - 2000 Bsf.', this.form)">
                      <label id="vehiculos" for="5ejes">B: VEHÍCULOS PESADOS (5 EJES O MÁS)</label>
                    </div><br>
                  </li>
                  <li class="active">
                    <div class="radio extento">
                      <a class="btn btn-default col-md-12 " onclick="changeImage('images/vehiculos/12.png', 'VEHÍCULO EXENTO DE PAGO', this.form)" data-toggle="modal" data-target="#modal_exentos" id="exte" >C: GENERAR EXENTO</a>
                    </div>
                  </li>
                </div>

              </ul>
            </div>
            <div class="col-sm-6 col-md-6">
            <div id="mensaje" style="background-color: #ecf0f1; margin-top: 50px; padding-bottom: 10px; border: 1px solid black;">
                <img src="images/vehiculos/12.png" alt="POR PUESTO" width="30%" id="imagen_vehiculo">
                <center><strong><i><h4><span id="vehiculo" style="padding-bottom: 5px">SISTEMA ESPECIALIZADO DE RECAUDACIÓN DE PEAJES</span></h4></i></strong></center>
              </div>
            </div>

            <input id="boton" class="btn btn-danger" style="margin-top:10px;" type="submit" name="imprimir" value="IMPRIMIR RECIBO DE PAGO" disabled="true">

          </form>
        </div>
      </div>
    </div>
    <div id="modal_exentos" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="text-center modal-title">GENERAR EXENTO</h4>
          </div>
          <form method="post" action="php/generar_exento.php" class="formulario" >
            <div class="modal-body">
              <?php
              include("php/menu_exentos.php");
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
  </div>

  <script type="text/javascript">
    function changeImage(image_src, text, form) {
      var img = document.getElementById("imagen_vehiculo");
      img.src= image_src;

      document.getElementById("vehiculo").textContent=text;

      habilita(form);

      return false;
    }

    function habilita(form){
      form.imprimir.disabled = false;
    }

    document.onkeypress = function hola(event) {
      var tecla;
      tecla = (document.all) ? event.keyCode : event.which;

      if(tecla == 49){
        document.getElementById('puesto').click();
        changeImage("images/vehiculos/1.png", "VEHÍCULOS POR PUESTO - 50 Bsf.");
      }
      if(tecla == 50){
        document.getElementById('moto').click();
        changeImage("images/vehiculos/2.png", "MOTOS A PARTIR DE 500CC - 100 Bsf.");
      }
      if(tecla ==51){
        document.getElementById('liv').click();
        changeImage("images/vehiculos/3.png", "VEHÍCULOS LIVIANOS Y MICRO BUSES - 100 Bsf.");
      }
      if(tecla ==52){
        document.getElementById('taxi').click();
        changeImage("images/vehiculos/4.png", "TAXIS - 100 Bsf.");
      }
      if(tecla ==53){
        document.getElementById('buses').click();
        changeImage("images/vehiculos/5.png", "BUSES COLECTIVOS - 300 Bsf.");
      }
      if(tecla ==54){
        document.getElementById('camion').click();
        changeImage("images/vehiculos/6.png", "CAMIÓN 350 (2 EJES) - 500 Bsf.");
      }
      if(tecla ==55){
        document.getElementById('750').click();
        changeImage("images/vehiculos/7.png", "CAMIÓN 750 - 600 Bsf.");
      }
      if(tecla ==56){
        document.getElementById('expres').click();
        changeImage("images/vehiculos/8.png", "BUSES EXPRESOS - 1000 Bsf.");
      }
      if(tecla ==57){
        document.getElementById('3ejes').click();
        changeImage("images/vehiculos/9.png", "VEHÍCULOS PESADOS (3 EJES) - 1000 Bsf.");
      }
      if(tecla ==65 || tecla==97){
        document.getElementById('4ejes').click();
        changeImage("images/vehiculos/10.png", "VEHÍCULOS PESADOS (4 EJES) - 1500 Bsf.");
      }
      if(tecla ==66 || tecla==98){
        document.getElementById('5ejes').click();
        changeImage("images/vehiculos/11.png", "VEHÍCULOS PESADOS (5 EJES O MÁS) - 2000 Bsf.");
      }
      if(tecla ==67 || tecla==99){
        document.getElementById('exte').click();
        changeImage("images/vehiculos/12.png", "VEHÍCULO EXENTO DE PAGO");
      }
      if(tecla ==13 || tecla == 32){
        document.getElementById('boton').click();
      }
    }
  </script>

  <style type="text/css">
    footer{
      text-align:center;
      border-top: 2px solid red;
      font-size: 13px;
      margin-top: 50px;
      font-weight: bold;
    }
  </style>
  <footer>
    <p>GOBERNACIÓN BOLIVARIANA DEL ZULIA - SERVICIOS VIALES DEL ZULIA (SERVIALEZ) (G-200117877) &copy; JULIO 2017</p>
  </footer>
  <div class="clearfix"></div>
</body>
</html>
