<?php
require("connect2db.php");
$rowset = mysqli_query($mysqli,"SELECT * FROM empleado WHERE cargo='2'");
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<br>
	<div align="middle">
		<div>
			<span ><span class="glyphicon glyphicon-calendar"></span> <b>DESDE:</b> <input type="date" name="desde" required min="2017-07-10"/></span>
			<span style="margin-left: 5%"><span  class="glyphicon glyphicon-calendar"></span> <b>HASTA:</b> <input type="date" name="hasta" min="2017-07-10" required/></span>
		</div>
	</div> 

	<br>

	<div align="middle" style="margin-left: 20%; text-align: center; width: 60%;">
		<span for="sel1" class="glyphicon glyphicon-list-alt"></span> <b>RECAUDADOR</b>
			<select name="operador" class="form-control" required="">
				<?php
				echo '<option value=" "></option>';
				foreach($rowset as $row) {
					echo '<option value="'.$row['cedula'].'">'.' CI: '.$row['cedula'].' - '.$row['nombre'].' '.$row['apellido'].'</option>';
				}
				?>
			</select>
	</div>
	<br>
	<style type="text/css">
		footer{
			text-align:center;
			border-top: 2px solid red;
			font-size: 13px;
		}
	</style>
</body>

</html>