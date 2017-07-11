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
	$filtro_operador = "AND usuario='$operador'";
}

function conversorSegundosHoras($tiempo_en_segundos) {
	$horas = floor($tiempo_en_segundos / 3600);
	$minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
	$segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

	return str_pad((int) $horas,2,"0",STR_PAD_LEFT) . ':' . str_pad((int) $minutos,2,"0",STR_PAD_LEFT) . ":" . str_pad((int) $segundos,2,"0",STR_PAD_LEFT);
}

$cont_ciclos = 1;

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
			$this->Cell(0, 15, 'SISTEMA ESPECIALIZADO DE RECAUDACIÓN DE PEAJES - REPORTE DE TIEMPOS DE CONEXIÓN', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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

	$pdf = new MYPDF('l', 'mm', 'A4', true, 'UTF-8', false);

	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Sistema Electrónico de Recaudación de Peajes');
	$pdf->SetTitle('Reporte de Tiempos de Conexión');

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
			<td height="20" style="text-align:center;background-color: #fdfefe;" colspan="4"><h1>REPORTE DE TIEMPOS DE CONEXIÓN</h1></td>
			<td colspan="3" rowspan="4" ><img src="../images/logopng.png" alt="Gobernación de Estado Zulia" style="aling:middle" width="350px" height="90px"></td>
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
				<th colspan="8" style="text-align:center;"><h3>REPORTE FILTRADO DEL OPERADOR: <u><em>'.$recaudador['nombre'].' '.$recaudador['apellido'].' - C.I: '.number_format((integer)$operador, 0, ',', '.').'</em></u><br></h3></th>
			</tr>';
		}
		$content .='
		<br>
		<tr style="background-color: #f2f3f4;">
			<td align="left" height=" 0" style="font-weight: bold" width="20">#</td>
			<td align="left" height=" 0" style="font-weight: bold; font-size: 10" width="110">RECAUDADOR</td>
			<td align="center" height="20" style="font-weight: bold; width:140; font-size: 10">HORA (CONEXIÓN)</td>
			<td align="center" height="20" style="font-weight: bold; width:140; font-size: 10">HORA (DESCONEXIÓN)</td>
			<td align="center" height="20" style="font-weight: bold; width:110; font-size: 10">FECHA (CONEXIÓN)</td>
			<td align="center" height="20" style="font-weight: bold; width:140; font-size: 10">FECHA (DESCONEXIÓN)</td>
			<td align="center" height="20" style="font-weight: bold; width:120px; font-size: 8">TIEMPO CONECTADO</td>
		</tr>
		';

		$logs = mysqli_query($mysqli, "SELECT * FROM log_login WHERE (fecha_de_conexion>='$desde' AND fecha_de_desconexion<='$hasta')".$filtro_operador."");

		while ($log= mysqli_fetch_assoc($logs)) {
			$usuario = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido, cargo FROM empleado WHERE cedula='".$log['usuario']."'"));

			if($usuario['cargo'] == 2){
				if(($cont_ciclos % 2) == 0){
					$content .= '<tr style="background-color: #f2f3f4">';
				}else{
					$content .= '<tr style="background-color: #fdfefe">';
				}
				
				if($log['hora_de_desconexion'] == '00:00:00'){
					$hora_de_desconexion = "CONECTADO";
				}else{
					$hora_de_desconexion = date("h:i A", strtotime($log['hora_de_desconexion']));
				}

				if($log['fecha_de_desconexion'] == '0000-00-00'){
					$fecha_de_desconexion = "CONECTADO";
				}else{
					$fecha_de_desconexion = date("d/m/Y", strtotime($log['fecha_de_desconexion']));
				}

				if($log['fecha_de_desconexion'] != '0000-00-00' && $log['hora_de_desconexion'] != '00:00:00'){
					$tiempo_conectado = conversorSegundosHoras(strtotime($log['fecha_de_desconexion'].' '.$log['hora_de_desconexion']) - strtotime($log['fecha_de_conexion'].' '.$log['hora_de_conexion']));
				}else{
					$tiempo_conectado = "CONECTADO";
				}

				$content .= '
					<td height="20" align="left">'.$cont_ciclos.'</td>
					<td height="20" align="left">'.$usuario['nombre'].' '.$usuario['apellido'].'</td>
					<td height="20" align="center">'.date("h:i A", strtotime($log['hora_de_conexion'])).'</td>
					<td height="20" align="center">'.$hora_de_desconexion.'</td>
					<td height="20" align="center">'.date("d/m/Y", strtotime($log['fecha_de_conexion'])).'</td>
					<td height="20" align="center">'.$fecha_de_desconexion.'</td>
					<td height="20" align="center">'.$tiempo_conectado.'</td>
				</tr>';

			$cont_ciclos += 1;
		}
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
	$pdf->output('Reporte de Tiempos de Conexión ('.$operador.') '.$desde.' '. $hasta.'.pdf', 'I');
}else{
	$pdf->output('Reporte de Tiempos de Conexión '.$desde.' '. $hasta.'.pdf', 'I');
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
				$h1 = "REPORTE DE TIEMPOS DE CONEXIÓN".'<br>';
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
							<th><center>RECAUDADOR</center></th>
							<th><center>HORA DE CONEXIÓN</center></th>
							<th><center>HORA DE DESCONEXIÓN</center></th>
							<th><center>FECHA(S)</center></th>
							<th><center>TIEMPO CONECTADO</center></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$logs = mysqli_query($mysqli, "SELECT * FROM log_login WHERE (fecha_de_conexion>='$desde' AND fecha_de_desconexion<='$hasta')".$filtro_operador."");
						while ($log=$logs->fetch_assoc()) {
							$usuario = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT nombre, apellido, cargo FROM empleado WHERE cedula='".$log['usuario']."'"));
							if($usuario['cargo'] == 2){?>
								<tr>
									<td><?php echo $usuario['nombre'].' '.$usuario['apellido']; ?></td>
									<td><center><?php echo $log['hora_de_conexion']; ?></center></td>
									<td><center><?php 
										if($log['hora_de_desconexion']== '00:00:00'){
											echo "CONECTADO";
										}else{
											echo $log['hora_de_desconexion'];
										}
										?></center></td>


										<?php 
										if($log['fecha_de_conexion'] == $log['fecha_de_desconexion']){
											$fechas = $log['fecha_de_conexion'];
										}elseif($log['fecha_de_desconexion'] == '0000-00-00'){
											$fechas = "CONECTADO";
										}else{
											$fechas = $log['fecha_de_conexion'].' / '.$log['fecha_de_desconexion'];
										}?>
										<td><center><?php echo $fechas; ?></center></td>

										<td><center><?php 
											if($log['fecha_de_desconexion'] != '0000-00-00'){
												echo conversorSegundosHoras(strtotime($log['fecha_de_desconexion'].' '.$log['hora_de_desconexion']) - strtotime($log['fecha_de_conexion'].' '.$log['hora_de_conexion']));
											}else{
												echo "CONECTADO";
											}
											?></center></td>

								</tr>
							<?php } ?>
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