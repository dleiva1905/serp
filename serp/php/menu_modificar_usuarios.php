<?php
require("connect2db.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/png" href="../images/ticket.png" />
</head>
<body>
	<div >
		<?php
		require("connect2db.php");

		$query_empleados = mysqli_query($mysqli, "SELECT * FROM empleado");

		echo '<table class="table table-hover">';
		echo '<tr class="warning">';
		echo '<td style="background-color: #f2f3f4;" align="center"><strong>CEDULA</strong></td>';
		echo '<td style="background-color: #f2f3f4;" align="center"><strong>NOMBRE COMPLETO</strong></td>';
		echo '<td style="background-color: #f2f3f4;" align="center"><strong>USUARIO</strong></td>';
		echo '<td style="background-color: #f2f3f4;" align="center"><strong>CABINA</strong></td>';
		echo '<td style="background-color: #f2f3f4;" align="center"><strong>ASIGNAR CABINA</strong></td>';
		echo '</tr>';

		while($arreglo_empleados = mysqli_fetch_array($query_empleados)){
			if($arreglo_empleados['cabina'] != 7){
				echo '<tr>';
				echo '<td align="center" style="font-weight: normal">'.$arreglo_empleados['cedula'].'</td>';
				echo '<td align="center" style="font-weight: normal">'.$arreglo_empleados['nombre'].' '.$arreglo_empleados['apellido'].'</td>';
				echo '<td align="center" style="text-align: center; font-weight: normal">'.$arreglo_empleados['usuario'].'</td>';
				echo '<td align="center" style="text-align: center; font-weight: normal">'.$arreglo_empleados['cabina'].'</td>';

				echo "<td style='text-align: center;'><a class='glyphicon glyphicon-retweet' href='../serp/php/asignar_cabina.php?id=$arreglo_empleados[0]'></td>";

				echo "</tr>";
			}
		}
		echo "</table>";
		?>
	</div>
</body>
</html>