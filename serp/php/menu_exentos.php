<?php
require("connect2db.php");
$rowset = mysqli_query($mysqli,"SELECT * FROM exento");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/png" href="../images/ticket.png" />
</head>
<body>
	<div>
		<div style="margin: 10px">
			<span style="padding-right: 24px;"><strong>TIPO DE VEHÍCULO</strong></span>
			<select style="width: 260px;" name="tipo_de_exento" >
				<?php
				foreach($rowset as $row) {
					echo '<option value="'.$row['id_exento'].'">'.$row['tipo_de_exento'].'</option>';
				}
				?>
			</select>
		</div>
		<div style="margin: 10px">
			<span><strong>PLACA DEL VEHÍCULO</strong></span>
			<input type="text" name="placa" size="30" placeholder="" maxlength="10" minlength="5" name="placa" required/>
		</div>
	</div>
</body>
</html>