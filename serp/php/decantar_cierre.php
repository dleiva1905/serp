<?php
require("connect2db.php");

$fecha_limite = date('Y/m/d', strtotime('+30 minutes'));

$rowset = mysqli_query($mysqli,"SELECT * FROM cierre WHERE fecha='$fecha_limite' AND (hora BETWEEN (NOW() - INTERVAL 40 MINUTE) AND (NOW()))");
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	
</head>
<body>
	<div class="form-group">
		<label for="sel1" class="glyphicon glyphicon-list-alt"> CIERRE A DECANTAR</label>
		<select class="form-control" id="cierre" name="cierre" required>
			<?php
				foreach($rowset as $row) {
					$cedula = $row['recaudador'];
					$personal =mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM empleado WHERE cedula='$cedula'"));
					echo '<option value="'.$row['id_cierre'].'">'.'ID #'.$row['id_cierre'].' - '.$personal['nombre'].' '.$personal['apellido'].'</option>';
				}
			?>
		</select>
	</div>
	<div class="form-group">
	  <label for="usr" class="glyphicon glyphicon-stats"> MONTO A DECANTAR</label>
	  <input type="number" class="form-control" id="monto" name="monto" required>
	</div>
	<style type="text/css">
		footer{
			text-align:center;
			border-top: 2px solid red;
			font-size: 13px;
		}
	</style>
</body>
</html>