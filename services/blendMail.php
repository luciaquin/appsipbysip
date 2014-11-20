<?php

include "config.php";


	$idBlend = $_POST["idBlend"];
	$nombreBlend = $_POST['nombreBlend'];
	$mailBlend = $_POST['mail'];




	echo "me llegaron los datos !! " . $idBlend . $nombreBlend . $mailBlend;

	//$conexion = mysqli_connect("localhost", "root", "", "appsipbysip");
	$conexion = mysql_connect($dbhost,$dbuser,$dbpass) or die ("error al conectar a la base de datos");
                  mysql_select_db($dbname) or die ("la base de datos no existe");

	$sql = "INSERT INTO notificaciones(idusr, emailusr, id, desiredBlend) VALUES('0','$mailBlend','$idBlend','$nombreBlend')";
	$consulta = mysql_query($sql, $conexion);
	

		
?>