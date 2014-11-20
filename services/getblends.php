<?php
include 'config.php';
	


	$sql= "SELECT newblends.id, newblends.blend, newblends.descripcion, newblends.precio, 
		newblends.idCodigoImg, imagenes.ruta, imagenes.nombre, imagenes.renombre 
		FROM newblends 
		LEFT JOIN imagenes 
		ON newblends.idCodigoImg=imagenes.idCodigoImg";	



try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->query($sql);  
	$blends = $stmt->fetchAll(PDO::FETCH_OBJ);
	$dbh = null;
	echo '{"items":'. stripslashes(utf8_encode(json_encode($blends))) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}


?>