<?php
session_start();

if($_SESSION['usuario']){	
	session_destroy();
	header("location:../index.php");
	die();
}
else{
	header("location:../index.php");
}
?>