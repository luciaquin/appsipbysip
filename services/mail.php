<?php
header("content-type= text/html; charset=utf-8");
include 'config.php';


if(isset($_POST['emailuser'])){
     
    $email_from = $_POST['emailuser'];

    $id = "SELECT blend FROM newblends WHERE id:id";
    $blend = $id;

    $sql = "INSERT INTO notificaciones(idusr,emailuser,id) VALUES('0','email','aca va el blend')"; 
    echo "al menos entro";
}    
 
try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);  
	$stmt->bindParam("id", $_GET["id"]);
	$stmt->execute();
	$blend = $stmt->fetchObject();  
	$dbh = null;
	echo '{"item":'. html_entity_decode(json_encode($blend)) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}

?>