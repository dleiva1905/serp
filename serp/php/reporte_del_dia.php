<?php
session_start();
$cedula = $_SESSION['cedula'];
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

header("Content-Type: text/html;charset=utf-8;");
date_default_timezone_set('America/Caracas');

require_once('connect2db.php');

$dia = $_POST['dia'];

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
			$this->Cell(0, 15, 'SISTEMA ESPECIALIZADO DE RECAUDACIÓN DE PEAJES - REPORTE DEL DIA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
	$pdf->SetAuthor('Sistema Electrónico de Recaudación de Peajes');
	$pdf->SetTitle('Reporte del Dia');

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

	$mes_dia = $meses[(int)date("m", strtotime($dia)) - 1];

	$content = '';
	$content .= '
	<table>
		<tr>
			<th colspan="6" style="text-align:center;" height="50"></th>
		</tr>
		<tr>
			<td height="20" style="text-align:center;background-color: #fdfefe;" colspan="3"><h1>REPORTE DEL DIA</h1></td>
			<td colspan="3" rowspan="4" ><img src="../images/logopng.png" alt="Gobernación de Estado Zulia" align="middle" width="300px" height="90px"></td>
		</tr>
		<tr>
			<td colspan="3" align="center" height="20" style="background-color: #fdfefe"><h2>Peaje <em>"SANTA RITA"</em></h2></td>
		</tr>
		<tr>
			<td colspan="3" align="center" height="20" style="background-color: #fdfefe"><h3>'.date("d", strtotime($dia)).' de '.$mes_dia.' del '.date("Y", strtotime($dia)).'</h3></td>
		</tr>
		<tr>
			<td colspan="3" align="center" height="20" style="background-color: #fdfefe"></td>
		</tr>
		<br>';

		$content .= '
		<tr style="background-color: #f2f3f4;">
			<td align="center" height=" 0" style="font-weight: bold;" width="50">CABINA</td>
			<td align="center" height="20" style="font-weight: bold;" width="105">CANT. CIERRE</td>
			<td align="center" height="20" style="font-weight: bold;" width="90">INGRESOS</td>
			<td align="center" height="20" style="font-weight: bold;" width="90">EXENTOS</td>
			<td align="center" height="20" style="font-weight: bold;" width="150">TOTAL RECAUDADO</td>
			<td align="center" height="20" style="font-weight: bold;" width="150">TOTAL DECLARADO</td>
			<td align="center" height="20" style="font-weight: bold;" width="150">TOTAL NO PERCIBIDO</td>
		</tr>
		';
		$cabinas = mysqli_query($mysqli, "SELECT id_cabina FROM cabina WHERE id_cabina!='7' AND id_cabina!='0'");

		$total_recaudado_final = 0;
		$total_declarado_final = 0;
		$total_no_percibido_final = 0;

		while ($cabina=$cabinas->fetch_assoc()) {
			$total_declarado_final_2 = 0;
			$cierres = mysqli_query($mysqli, "SELECT id_cierre FROM cierre WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'");

			while($cierre = $cierres->fetch_assoc()){
				$decantacion = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT monto_declarado FROM decantacion WHERE cierre='".$cierre['id_cierre']."'"));

				if($decantacion != '' || $decantacion != null){
					$total_declarado_final_2 += (integer)$decantacion['monto_declarado'];
				}
			}

			$cantidad_de_cierres = mysqli_num_rows(mysqli_query($mysqli, "SELECT id_cierre FROM cierre WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

			$cantidad_de_ingresos = mysqli_num_rows(mysqli_query($mysqli, "SELECT id_registro FROM registro WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

			$cantidad_de_exentos = mysqli_num_rows(mysqli_query($mysqli, "SELECT id_registro_exento FROM registro_exento WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

			$total_recaudado = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto) FROM registro WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

			$total_no_percibido = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto) FROM registro_exento WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

			$total_declarado = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto_declarado) FROM decantacion WHERE fecha='".$dia."'"));

			if($cont_ciclos%2==0){
				$content .= '<tr style="background-color: #fdfefe">';
			}else{
				$content .= '<tr style="background-color: #f2f3f4">';
			}

			$content .= '
			<td height="20" align="center">'.$cabina['id_cabina'].'</td>
			<td height="20" align="center">'.$cantidad_de_cierres.'</td>
			<td height="20" align="center">'.$cantidad_de_ingresos.'</td>
			<td height="20" align="center">'.$cantidad_de_exentos.'</td>
			<td height="20" align="center">'.number_format($total_recaudado['SUM(monto)'], 0, ',', '.').' Bsf</td>
			<td height="20" align="center">'.number_format($total_declarado_final_2, 0, ',', '.').' Bsf</td>
			<td height="20" align="center">'.number_format($total_no_percibido['SUM(monto)'], 0, ',', '.').' Bsf</td>
		</tr>';

		$cont_ciclos += 1;
		

		$total_declarado_final = 0;
		$cierres = mysqli_query($mysqli, "SELECT id_cierre FROM cierre WHERE fecha='".$dia."'");

		while($cierre = $cierres->fetch_assoc()){
			$decantacion = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT monto_declarado FROM decantacion WHERE cierre='".$cierre['id_cierre']."'"));

			if($decantacion != '' || $decantacion != null){
				$total_declarado_final += (integer)$decantacion['monto_declarado'];
			}
		}

		if($total_recaudado_final - $total_declarado_final > 0){
			$mensaje = "FALTAN: ".number_format($total_recaudado_final - $total_declarado_final, 0, ',', '.').' Bsf (FALTA)';
		}elseif($total_recaudado_final - $total_declarado_final < 0){
			$mensaje = "SOBRAN: ".number_format($total_declarado_final - $total_recaudado_final, 0, ',', '.').' Bsf';
		}else{
			$mensaje = "¡CUADRE EXACTO!";
		}

		$total_recaudado_final += (integer)$total_recaudado['SUM(monto)'];
		$total_no_percibido_final += (integer)$total_no_percibido['SUM(monto)'];
	}
	$content .= '
</table>
<table>
	<tr>
		<td colspan="10"></td>
	</tr>
	<tr>
		<td colspan="5" align="right">TOTAL RECAUDADO (SISTEMA):</td>
		<td colspan="5" align="left">     '.number_format($total_recaudado_final, 0, ',', '.').' Bsf</td>
	</tr>
	<tr>
		<td colspan="5" align="right">TOTAL DECLARADO (FÍSICO):</td>
		<td colspan="5" align="left">     '.number_format($total_declarado_final, 0, ',', '.').' Bsf</td>
	</tr>
	<tr>
		<td colspan="5" align="right">TOTAL NO PERCIBIDO POR EXENTO:</td>
		<td colspan="5" align="left">     '.number_format($total_no_percibido_final, 0, ',', '.').' Bsf</td>
	</tr>
	<tr>
		<td colspan="5" align="right">DECANTACIÓN:</td>
		<td colspan="5" align="left">     '.$mensaje.'</td>
	</tr>
</table>
<br><br><br><br><br><br><br>
<span style="text-align:center">______________________________<br><br>'.$_SESSION['nombre'].' '.$_SESSION['apellido'].'<br>C.I: '.$_SESSION['cedula'].'<br>TESORERO</span>
';

$pdf->writeHTML($content, true, 0, true, 0);

$pdf->lastPage();

$pdf->output('Reporte del Dia '.$dia.'.pdf', 'I');

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
				$h1 = "REPORTE DEL DIA".'<br>';
				echo '<h1>'.$h1.'</h1>'.'<center><h3>'.date("d/m/Y", strtotime($dia)).'</h3></center>';?>
			</div>
		</div>
		<div class="row">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>CABINA</th>
						<th><center>CANT. CIERRES</center></th>
						<th><center>INGRESOS</center></th>
						<th><center>EXENTOS</center></th>
						<th><center>TOTAL RECAUDADO</center></th>
						<th><center>TOTAL DECLARADO</center></th>
						<th><center>TOTAL NO PERCIBIDO</center></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$cabinas = mysqli_query($mysqli, "SELECT id_cabina FROM cabina WHERE id_cabina!='7' AND id_cabina!='0'");

					$total_recaudado_final = 0;
					$total_declarado_final = 0;
					$total_no_percibido_final = 0;

					while ($cabina=$cabinas->fetch_assoc()) {

						$total_declarado_final_2 = 0;
						$cierres = mysqli_query($mysqli, "SELECT id_cierre FROM cierre WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'");

						while($cierre = $cierres->fetch_assoc()){
							$decantacion = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT monto_declarado FROM decantacion WHERE cierre='".$cierre['id_cierre']."'"));

							if($decantacion != '' || $decantacion != null){
								$total_declarado_final_2 += (integer)$decantacion['monto_declarado'];
							}
						}

						$cantidad_de_cierres = mysqli_num_rows(mysqli_query($mysqli, "SELECT id_cierre FROM cierre WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

						$cantidad_de_ingresos = mysqli_num_rows(mysqli_query($mysqli, "SELECT id_registro FROM registro WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

						$cantidad_de_exentos = mysqli_num_rows(mysqli_query($mysqli, "SELECT id_registro_exento FROM registro_exento WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

						$total_recaudado = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto) FROM registro WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

						$total_no_percibido = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto) FROM registro_exento WHERE fecha='".$dia."' AND cabina='".$cabina['id_cabina']."'"));

						$total_declarado = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(monto_declarado) FROM decantacion WHERE fecha='".$dia."'"));
						?>
						<tr>
							<td><center><?php echo $cabina['id_cabina']; ?></center></td>
							<td><center><?php echo $cantidad_de_cierres; ?></center></td>
							<td><center><?php echo $cantidad_de_ingresos; ?></center></td>
							<td><center><?php echo $cantidad_de_exentos; ?></center></td>
							<td><center><?php echo number_format($total_recaudado['SUM(monto)'], 0, ',', '.'); ?> Bsf</center></td>
							<td><center><?php echo number_format($total_declarado_final_2, 0, ',', '.'); ?> Bsf</center></td>
							<td><center><?php echo number_format($total_no_percibido['SUM(monto)'], 0, ',', '.'); ?> Bsf</center></td>
						</tr>
						<?php

						$total_declarado_final = 0;
						$cierres = mysqli_query($mysqli, "SELECT id_cierre FROM cierre WHERE fecha='".$dia."'");

						while($cierre = $cierres->fetch_assoc()){
							$decantacion = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT monto_declarado FROM decantacion WHERE cierre='".$cierre['id_cierre']."'"));

							if($decantacion != '' || $decantacion != null){
								$total_declarado_final += (integer)$decantacion['monto_declarado'];
							}
						}

						if($total_recaudado_final - $total_declarado_final > 0){
							$mensaje = "FALTAN: ".number_format($total_recaudado_final - $total_declarado_final, 0, ',', '.').' Bsf';
						}elseif($total_recaudado_final - $total_declarado_final < 0){
							$mensaje = "SOBRAN: ".number_format($total_declarado_final - $total_recaudado_final, 0, ',', '.').' Bsf';
						}else{
							$mensaje = '¡CUADRE EXACTO!';
						}

						$total_recaudado_final += (integer)$total_recaudado['SUM(monto)'];
						$total_no_percibido_final += (integer)$total_no_percibido['SUM(monto)'];
					}?>
				</tbody>
			</table>
			<table>
				<tr>
					<th colspan="6"></th>
				</tr>
				<tr>
					<th colspan="2" width="300">TOTAL RECAUDADO (SISTEMA)</th>
					<td colspan="4" align="left"><?php echo number_format($total_recaudado_final, 0, ',', '.'); ?> Bsf</td>
				</tr>
				<tr>
					<th colspan="2" width="300">TOTAL DECLARADO (FÍSICO)</th>
					<td colspan="4" align="left"><?php echo number_format($total_declarado_final, 0, ',', '.'); ?> Bsf</td>
				</tr>
				<tr>
					<th colspan="2" width="300">TOTAL NO PERCIBIDO POR EXENTO</th>
					<td colspan="4" align="left"><?php echo number_format($total_no_percibido_final, 0, ',', '.'); ?> Bsf</td>
				</tr>
				<tr>
					<th colspan="2" width="300">DECANTACIÓN</th>
					<td colspan="4" align="left"><?php echo $mensaje;?></td>
				</tr>
			</table>
			<div class="col-md-12">
				<form method="post">
					<input type="text" name="dia" readonly="readonly" style="border: 0; display : none" value="<?php echo $_POST['dia'] ?>"/>

					<input type="hidden" name="reporte_name" value="<?php echo $h1; ?>">
					<input type="submit" name="create_pdf" class="btn btn-danger pull-right" value="Generar PDF">
				</form>
			</div>
		</div>
	</div>
</body>
</html>
