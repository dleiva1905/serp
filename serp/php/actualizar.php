<?php
$cedula_usuario_a_editar = $_POST['cedula'];
$cabina_a_asignar = $_POST['cabina_asignada'];

require("connect2db.php");

$verificar_cabina_a_asignar = mysqli_query($mysqli, "SELECT * FROM empleado WHERE cabina='$cabina_a_asignar'");

if(mysqli_num_rows($verificar_cabina_a_asignar) > 0){
	/* VERIFICAMOS SI LA CABINA QUE SE LE QUIERE ASIGNAR AL USUARIO ESTA OCUPADA */

	echo '<script>alert("LA CABINA ESTA OCUPADA")</script> ';
	echo "<script>location.href='../administrador.php'</script>";
}else{
	/* SI NO ESTA OCUPADA, PROCEDEMOS A VERIFICAR LA CABINA EN LA QUE ESTA EL USUARIO QUE SE QUIERE MODIFICAR */
	if($cabina_a_asignar > 0){
		echo '<script>alert("LA CABINA ESTA DESOCUPADA")</script> ';
	}
	
	$empleado_a_verificar = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT cabina FROM empleado WHERE cedula='$cedula_usuario_a_editar'"));

	if($empleado_a_verificar['cabina'] > 0){
		/* SI NO ESTA EN LA CABINA '0', SE VERIFICA SI TIENE DINERO EN CAJA */
		$cabina_actual = $empleado_a_verificar['cabina'];
		$dinero_en_cabina_actual = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT dinero_actual FROM cabina WHERE id_cabina='$cabina_actual'"));

		if( $dinero_en_cabina_actual['dinero_actual'] > 0){
			/* SI EL DINERO EN CAJA EN SU CABINA ACTUAL ES MAYOR A '0', SE HACE EL CIERRE, Y SE ACTUALIZA SU CABINA */
			echo '<script>alert("HAY DINERO EN CAJA, SE REALIZARÁ UN CIERRE AUTOMÁTICO POR '.$dinero_en_cabina_actual['dinero_actual'].' Bsf")</script>';

			$dinero = $dinero_en_cabina_actual['dinero_actual'];

			/* CIERRE DE CAJA */

			$fecha = date('Y/m/d', strtotime('+30 minutes'));
			$hora = date('H:i:s', strtotime('+30 minutes'));

			$registro = mysqli_query($mysqli, "INSERT INTO cierre VALUES ('', '$cedula_usuario_a_editar', '$cabina_actual', '$fecha', '$hora', '$dinero');");

			echo '<script>alert("SE GENERÓ EL CIERRE DE CAJA CORRECTAMENTE!")</script>';
		}
		mysqli_query($mysqli, "UPDATE empleado SET cabina='$cabina_a_asignar' WHERE cedula = '$cedula_usuario_a_editar'");
		mysqli_query($mysqli, "UPDATE cabina SET dinero_actual='0' WHERE id_cabina='$cabina_actual'");

		if($cabina_a_asignar > 0){
			echo '<script>alert("¡SE ASIGNÓ LA CABINA CORRECTAMENTE!")</script>';
		}else{
			echo '<script>alert("EL OPERADOR HA SIDO DESHABILITADO.")</script>';
		}
		
		echo "<script>location.href='../administrador.php'</script>";
	}else{
		mysqli_query($mysqli, "UPDATE empleado SET cabina='$cabina_a_asignar' WHERE cedula = '$cedula_usuario_a_editar'");

		echo '<script>alert("¡SE ASIGNO LA CABINA CORRECTAMENTE!")</script>';
		echo "<script>location.href='../administrador.php'</script>";
	}
}