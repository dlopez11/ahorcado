<?php
	$host = 'localhost';
	$user = 'root';
	$pass = 'dorian001';
	$database	= 'ahorcado';
	
	$link = mysqli_connect($host,$user,$pass) or die('no hay conexion a la base de datos');
	
	mysqli_select_db($link, $database);
?>