<?php
session_start();
$cedula = $_SESSION['cedula'];
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

header("Content-Type: text/html;charset=utf-8;");
date_default_timezone_set('America/Caracas');

require_once('connect2db.php');

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$operador = $_POST['operador'];

if($operador == '' || $operador == ' '){
	$filtro_operador = "";
}else{
	$filtro_operador = "AND recaudador='$operador'";
}

$cont_ciclos = 0;
$exentos = mysqli_query($mysqli, "SELECT * FROM registro_exento WHERE fecha>='$desde' AND fecha<='$hasta'".$filtro_operador."");
$cantidad_de_registros = mysqli_num_rows($exentos);
$total_no_percibido = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto) FROM registro_exento WHERE fecha>='$desde' AND fecha<='$hasta'".$filtro_operador.""));

if(isset($_POST['create_pdf'])){
	require_once('../lib/tcpdf/tcpdf.php');

	setlocale(LC_ALL,"es_ES");

// Extend the TCPDF class to create custom Header and Footer
  class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Set font
      $font = $this->addTTFfont("../fonts/novamono.ttf");
      $this->SetFont($font,'',25);
        // Title
      $this->Cell(0, 15, 'SISTEMA ESPECIALIZADO DE RECAUDACIÓN DE PEAJES - REPORTE DE EXENTOS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
      $this->SetY(-15);
        // Set font
      $font = $this->addTTFfont("../fonts/larabiefont rg.ttf");
      $this->SetFont($font,'',7);
        // Page number
      $this->info = strftime("%A %d de %B del %Y").' a las '.date('h:i A'/*, strtotime('+30 minutes')*/).' por '.$_SESSION['nombre'].' '.$_SESSION['apellido'].' C.I: '.$_SESSION['cedula'];
      $this->Cell(0, 10, 'Reporte generado el '.$this->info.' (Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().')', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
  }

	$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);

	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Sistema Electrónico de Recaudación de Peajes');
	$pdf->SetTitle('Reporte de Exentos');

	$pdf->setPrintHeader(true); 
	$pdf->setPrintFooter(true);
	$pdf->setHeaderMargin(15);
	$pdf->setFooterMargin(15);
	$pdf->SetMargins(10, 5, 10, false); 
	$pdf->SetAutoPageBreak(true, 20); 
	$font = $pdf->addTTFfont("../fonts/larabiefont rg.ttf");
	$pdf->SetFont($font,'',10);
	$pdf->addPage();

	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 

	$mes_desde = $meses[(int)date("m", strtotime($desde)) - 1];
	$mes_hasta = $meses[(int)date("m", strtotime($hasta)) - 1];

	$content = '';
	$content .= '
	<table>
		<tr>
			<th colspan="6" style="text-align:center;" height="50"></th>
		</tr>
		<tr>
			<td height="20" style="text-align:center;background-color: #fdfefe;" colspan="3"><h1>REPORTE DE EXENTOS</h1></td>
			<td colspan="3" rowspan="4" ><img src="../images/logopng.png" alt="Gobernación de Estado Zulia" align="middle" width="300px" height="90px"></td>
		</tr>
		<tr>
			<td colspan="3" align="center" height="20" style="background-color: #fdfefe"><h2>Peaje <em>"SANTA RITA"</em></h2></td>
		</tr>
		<tr>
			<td colspan="3" align="center" height="20" style="background-color: #fdfefe"><h3>Desde el '.date("d", strtotime($desde)).' de '.$mes_desde.' del '.date("Y", strtotime($desde)).'</h3></td>
		</tr>
		<tr>
			<td colspan="3" align="center" height="20" style="background-color: #fdfefe"><h3>Hasta el '.date("d", strtotime($hasta)).' de '.$mes_hasta.' del '.date("Y", strtotime($hasta)).'</h3></td>
		</tr>
		<br>';

		if($operador != '' && $operador != ' '){
			$recaudador = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido FROM empleado WHERE cedula='$operador'"));
			$content .= '
			<tr>
				<th colspan="6" style="text-align:center;"><h3>REPORTE FILTRADO DEL OPERADOR: <u><em>'.$recaudador['nombre'].' '.$recaudador['apellido'].' - C.I: '.number_format((integer)$operador, 0, ',', '.').'</em></u><br></h3></th>
			</tr>';
		}
		$content .= '
		<tr>
			<td align="left" style="font-weight: bold">CANTIDAD DE REGISTROS</td>
			<td colspan="2" align="center" style="font-weight: bold">'.number_format($cantidad_de_registros, 0, ',', '.').' Registros</td>
			<td align="left" style="font-weight: bold">     TOTAL NO PERCIBIDO</td>
			<td colspan="2" align="center" style="font-weight: bold">'.number_format($total_no_percibido['SUM(monto)'], 0, ',', '.').' Bsf</td>
		</tr>
		<br>
		<tr style="background-color: #f2f3f4;">
			<td align="left" height=" 0" style="font-weight: bold" width="255">TIPO DE VEHÍCULO</td>
			<td align="left" height="20" style="font-weight: bold; width:130px">RECAUDADOR</td>
			<td align="center" height="20" style="font-weight: bold; width:100px">CABINA</td>
			<td align="center" height="20" style="font-weight: bold; width:100px">FECHA</td>
			<td align="center" height="20" style="font-weight: bold; width:100px">HORA</td>
			<td align="center" height="20" style="font-weight: bold; width:100px">VALOR</td>
		</tr>
		';
		while ($exento= mysqli_fetch_assoc($exentos)) {
			$tipo = $exento['tipo_de_exento'];

			$tipo_de_exento = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT tipo_de_exento FROM exento WHERE id_exento='$tipo'"));
			if($cont_ciclos%2==0){
				$content .= '<tr style="background-color: #fdfefe">';
			}else{
				$content .= '<tr style="background-color: #f2f3f4">';
			}

			$reca = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido FROM empleado WHERE cedula='".$exento['recaudador']."'"));

			$content .= '
			<td height="20" align="left">'.$tipo_de_exento['tipo_de_exento'].'</td>
			<td height="20" align="left">'.$reca['nombre'].' '.$reca['apellido'].'</td>
			<td height="20" align="center">'.$exento['cabina'].'</td>
			<td height="20" align="center">'.date("d-m-Y", strtotime($exento['fecha'])).'</td>
			<td height="20" align="center">'.date("h:i A", strtotime($exento['hora'])).'</td>
			<td height="20" align="center">'.number_format($exento['monto'], 0, ',', '.').' Bsf</td>
		</tr>';

		$cont_ciclos += 1;
	}

	$content .= '
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>
';

$pdf->writeHTML($content, true, 0, true, 0);

$pdf->lastPage();

if($operador != '' && $operador != ' '){
	$pdf->output('Reporte de Exentos ('.$operador.') '.$desde.' '. $hasta.'.pdf', 'I');
}else{
	$pdf->output('Reporte de Exentos '.$desde.' '. $hasta.'.pdf', 'I');
}

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Sistema de Recaudación</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
<!-- Meta Mobil
	================================================== -->
	<meta name="viewport" content="width=device-width, cierre-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<link rel="icon" type="image/png" href="../images/ticket.png" />

	<!-- Bootstrap -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>

<body>
	<div class="container-fluid">
		<div class="row padding">
			<div class="col-md-12">
				<?php 
				$h1 = "REPORTE DE EXENTOS".'<br>';
				echo '<h1>'.$h1.'</h1>'.'<center><h3>'.date("d/m/Y", strtotime($desde)).' - '.date("d/m/Y", strtotime($hasta)).'</h3></center>';

				if($operador != ' '){?>
				<tr>
					<th colspan="4" style="text-align:center;"><center><h4>REPORTE FILTRADO DEL OPERADOR: <u><em>
						<?php 
						$reca = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido FROM empleado WHERE cedula='$operador'"));
						echo $reca['nombre'].' '.$reca['apellido'].' - C.I: '.number_format($operador, 0, ',', '.'); ?></em></u><br></h4></center></th>
					</tr>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>TIPO DE VEHÍCULO</th>
							<th><center>FECHA</center></th>
							<th><center>HORA</center></th>
							<th><center>VALOR</center></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$exentos = mysqli_query($mysqli, "SELECT * FROM registro_exento WHERE fecha>='$desde' AND fecha<='$hasta'".$filtro_operador."");
						while ($exento=$exentos->fetch_assoc()) {
							$tipo = $exento['tipo_de_exento'];

							$tipo_de_exento = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT tipo_de_exento FROM exento WHERE id_exento='$tipo'"));
							?>
							<tr>
								<td><?php echo $tipo_de_exento['tipo_de_exento']; ?></td>
								<td><center><?php echo $exento['fecha']; ?></center></td>
								<td><center><?php echo $exento['hora']; ?></center></td>
								<td><center><?php echo number_format($exento['monto'], 0, ',', '.'); ?> Bsf</center></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="col-md-12">
						<form method="post">
							<input type="text" name="desde" readonly="readonly" style="border: 0; display : none" value="<?php echo $_POST['desde'] ?>"/>
							<input type="text" name="hasta" readonly="readonly" style="border: 0; display : none" value="<?php echo $_POST['hasta'] ?>"/>
							<input type="text" name="operador" readonly="readonly" style="border: 0; display : none" value="<?php echo $_POST['operador'] ?>"/>

							<input type="hidden" name="reporte_name" value="<?php echo $h1; ?>">
							<input type="submit" name="create_pdf" class="btn btn-danger pull-right" value="Generar PDF">
						</form>
					</div>
				</div>
			</div>
		</body>
		</html>