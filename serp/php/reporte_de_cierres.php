<?php
session_start();
$cedula = $_SESSION['cedula'];
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

header("Content-Type: text/html;charset=utf-8;");

require_once('connect2db.php');

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$operador = $_POST['operador'];

if($operador == '' || $operador == ' '){
	$filtro_operador = "";
}else{
	$filtro_operador = "AND recaudador='$operador'";
}

$cierres = mysqli_query($mysqli, "SELECT * FROM cierre WHERE fecha>='$desde' AND fecha<='$hasta'".$filtro_operador."");
$cantidad_de_cierres = mysqli_num_rows($cierres);

$total_recaudado = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto_recaudado) FROM cierre WHERE fecha>='$desde' AND fecha<='$hasta'"));
$cont_ciclos = 0;

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
			$this->Cell(0, 15, 'SISTEMA ESPECIALIZADO DE RECAUDACIÓN DE PEAJES - REPORTE DE CIERRES', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		}

    // Page footer
		public function Footer() {
        // Position at 15 mm from bottom
			$this->SetY(-15);
        // Set font
			$font = $this->addTTFfont("../fonts/larabiefont rg.ttf");
			$this->SetFont($font,'',7);
        // Page number
			$this->info = strftime("%A %d de %B del %Y").' a las '.date('h:i A', strtotime('+30 minutes')).' por '.$_SESSION['nombre'].' '.$_SESSION['apellido'].' C.I: '.$_SESSION['cedula'];
			$this->Cell(0, 10, 'Reporte generado el '.$this->info.' (Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().')', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}

	$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);

	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Sistema Electrónico de Recaudación de Peajes - REPORTE DE CIERRES');
	$pdf->SetTitle('Reporte de Cierres');

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
	<table style="margin: 0 auto;">
		<tr>
			<th colspan="8" style="text-align:center;" height="50"></th>
		</tr>
		<tr>
			<td height="20" style="text-align:center;background-color: #fdfefe;" colspan="4"><h1>REPORTE DE CIERRES</h1></td>
			<td colspan="4" rowspan="4" ><img src="../images/logopng.png" alt="Gobernación de Estado Zulia" style="aling:middle" width="300px" height="90px"></td>
		</tr>
		<tr>
			<td colspan="4" align="center" height="20" style="background-color: #fdfefe"><h2>Peaje <em>"SANTA RITA"</em></h2></td>
		</tr>
		<tr>
			<td colspan="4" align="center" height="20" style="background-color: #fdfefe"><h3>Desde el '.date("d", strtotime($desde)).' de '.$mes_desde.' del '.date("Y", strtotime($desde)).'</h3></td>
		</tr>
		<tr>
			<td colspan="4" align="center" height="20" style="background-color: #fdfefe"><h3>Hasta el '.date("d", strtotime($hasta)).' de '.$mes_hasta.' del '.date("Y", strtotime($hasta)).'</h3></td>
		</tr>
		<br>';

		if($operador != '' && $operador != ' '){
			$recaudador = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido FROM empleado WHERE cedula='$operador'"));
			$content .= '
			<tr>
				<th colspan="8" style="text-align:center;"><h3>REPORTE FILTRADO DEL OPERADOR: <u><em>'.$recaudador['nombre'].' '.$recaudador['apellido'].' - C.I: '.number_format($operador, 0, ',', '.').'</em></u></h3><br></th>
			</tr>';
		}
		$content .= '
		<tr>
			<td align="left" style="font-weight: bold" colspan="2">CANTIDAD DE CIERRES</td>
			<td align="center" style="font-weight: bold">'.number_format($cantidad_de_cierres, 0, ',', '.').' Cierre(s)</td>
			<td></td>
			<td align="left" style="font-weight: bold" colspan="2">     TOTAL RECAUDADO</td>
			<td style="font-weight: bold">'.number_format($total_recaudado['SUM(monto_recaudado)'], 0, ',', '.').' Bsf</td>
		</tr>
		<br>
		<tr style="background-color: #f2f3f4;">
			<th align="left" style="width: 50px"><strong>CÓDIGO</strong></th>
			<th align="left" width="120" ><strong>RECAUDADOR</strong></th>
			<th align="center" width="60"><strong>CABINA</center></strong></th>
			<th align="center" width="150"><strong>FECHA / HORA</strong></th>
			<th align="center"><strong>MONTO</strong></th>
			<th align="center" width="145"><strong>MONTO DECLARADO</strong></th>
			<th align="center" width="160"><strong>DIFERENCIA</strong></th>
		</tr>
		';
		while ($cierre= mysqli_fetch_assoc($cierres)) {
			$decantacion = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT monto_declarado FROM decantacion WHERE cierre='".$cierre['id_cierre']."'"));

			if($cont_ciclos%2==0){
				$content .= '<tr style="background-color: #fdfefe">';
			}else{
				$content .= '<tr style="background-color: #f2f3f4">';
			}

			if($cierre['monto_recaudado'] - $decantacion['monto_declarado'] > 0){
				$mensaje = "FALTAN: ".number_format($cierre['monto_recaudado'] - $decantacion['monto_declarado'], 0, ',', '.')." Bsf";
			}elseif($cierre['monto_recaudado'] - $decantacion['monto_declarado'] < 0){
				$mensaje = "SOBRAN: ".number_format($decantacion['monto_declarado'] - $cierre['monto_recaudado'], 0, ',', '.')." Bsf";
			}else{
				$mensaje = "¡CUADRE EXACTO!";
			}

			$reca = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido FROM empleado WHERE cedula='".$cierre['recaudador']."'"));
			$content .= '
			<td align="left">'.str_pad((int) $cierre['id_cierre'],6,"0",STR_PAD_LEFT).'</td>
			<td align="left">'.$reca['nombre'].' '.$reca['apellido'].'</td>
			<td align="center">'.$cierre['cabina'].'</td>
			<td align="center">'.date("d-m-Y", strtotime($cierre['fecha'])).' '.date("h:i A", strtotime($cierre['hora'])).'</td>

			<td align="center">'.number_format($cierre['monto_recaudado'], 0, ',', '.').' Bsf</td>
			<td align="center">'.number_format($decantacion['monto_declarado'], 0, ',', '.').' Bsf</td>
			<td align="center">'.$mensaje.'</td>
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
	$pdf->output('Reporte de Cierres ('.$operador.') '.$desde.' '. $hasta.'.pdf', 'I');
}else{
	$pdf->output('Reporte de Cierres '.$desde.' '. $hasta.'.pdf', 'I');
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
				$h1 = "REPORTE DE CIERRES".'<br>';
				echo '<h1>'.$h1.'</h1>'.'<center><h3>'.date("d/m/Y", strtotime($desde)).' - '.date("d/m/Y", strtotime($hasta)).'</h3></center>';

				if($operador != ' '){?>
				<tr>
					<th colspan="4" style="text-align:center;"><center><h4>REPORTE FILTRADO DEL OPERADOR: <u><em>
						<?php 
						$reca = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido FROM empleado WHERE cedula='$operador'"));
						echo $reca['nombre'].' '.$reca['apellido'].' C.I: '.number_format($operador, 0, ',', '.'); ?></u></em><br></h4></center></th>
					</tr>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ID CIERRE</th>
							<th><center>RECAUDADOR</center></th>
							<th><center>CABINA</center></th>
							<th><center>FECHA</center></th>
							<th><center>HORA</center></th>
							<th><center>MONTO</center></th>
							<th><center>MONTO DECLARADO</center></th>
							<th><center>DIFERENCIA</center></th>
						</tr>
					</thead>
					<tbody>
						<?php

						$cierres = mysqli_query($mysqli, "SELECT * FROM cierre WHERE fecha>='$desde' AND fecha<='$hasta' ".$filtro_operador."");

						while ($cierre= mysqli_fetch_assoc($cierres)) {
							$cierre_actual = $cierre['id_cierre'];

							$declaracion = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT monto_declarado FROM decantacion WHERE cierre='$cierre_actual'"));

							$recaudador_actual = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido FROM empleado WHERE cedula='".$cierre['recaudador']."'"));
							?>
							<tr>
								<td><?php echo str_pad((int) $cierre['id_cierre'],7,"0",STR_PAD_LEFT); ?></td>
								<td><center><?php echo $recaudador_actual['nombre'].' '.$recaudador_actual['apellido']; ?></center></td>
								<td><center><?php echo $cierre['cabina']; ?></center></td>
								<td><center><?php echo $cierre['fecha']; ?> </center></td>
								<td><center><?php echo $cierre['hora']; ?> </center></td>
								<td><center><?php echo number_format($cierre['monto_recaudado'], 0, ',', '.'); ?> Bsf</center></td>
								<td><center><?php echo number_format($declaracion['monto_declarado'], 0, ',', '.'); ?> Bsf</center></td>
								<td><center><?php 
									if($cierre['monto_recaudado'] - $declaracion['monto_declarado'] > 0){
										echo "FALTAN: ".number_format($cierre['monto_recaudado'] - $declaracion['monto_declarado'], 0, ',', '.')." Bsf";
									}elseif($cierre['monto_recaudado'] - $declaracion['monto_declarado'] < 0){
										echo "SOBRAN: ".number_format($declaracion['monto_declarado'] - $cierre['monto_recaudado'], 0, ',', '.')." Bsf";
									}else{
										echo "¡CUADRE EXACTO!";
									}
									?></center>
								</td>
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