<?php


header("content-type= text/html; charset=utf-8");
include 'config.php';

$idBuscado = $_GET['idBlend'];

//$sql = "SELECT * FROM newblends WHERE id=:id";	
$sql= "SELECT newblends.id, newblends.blend, newblends.descripcion, newblends.precio, 
		newblends.idCodigoImg, imagenes.ruta 
		FROM newblends 
		LEFT JOIN imagenes 
		ON newblends.idCodigoImg=imagenes.idCodigoImg
		WHERE id='$idBuscado'";


/*
$sql= "SELECT newblends.id, newblends.blend, newblends.descripcion, newblends.precio, 
		newblends.idCodigoImg, imagenes.ruta, imagenes.nombre, imagenes.renombre 
		FROM newblends 
		where id = $idBuscado";
*/
try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);  
	$stmt->bindParam("id", $_GET["id"]);
	$stmt->execute();
	$blend = $stmt->fetchObject();  
	$dbh = null;
	echo '{"blend":'. json_encode($blend) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}


?>