<?php

$mysqli = new MySQLi("localhost", "root","JP{G7jFp", "serp");
$acentos = mysqli_query($mysqli,"SET NAMES 'utf8'");
if ($mysqli -> connect_errno) {
	die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno()
		. ") " . $mysqli -> mysqli_connect_error());
}
?>
