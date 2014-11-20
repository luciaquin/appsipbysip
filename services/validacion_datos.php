<?php
 
 //include "config.php";
 
/* Extrae los valores enviados desde la aplicacion movil */
//$usuarioEnviado = $_GET['usuario'];


/* nos conectamos a la db */
//$conexion = mysqli_connect("127.0.0.1", "root", "", "appsipbysip");



//$consulta = "SELECT * FROM Usuarios WHERE Usuario='$usuarioEnviado'";
//$consulta = "INSERT INTO notificaciones(idusr, emailuser, id)VALUES('0','$usuarioEnviado','id')";

$resultado = array();
$resultado["validacion"] ="ok";

$resultadoJSON = json_encode($resultado);

echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

/*$resultado = mysqli_query($conexion, $consulta);

if($resultado->num_rows){
	$resultado->data_seek(0);
	$fila = $resultado -> fetch_assoc();
	$usuarioValido = $fila['emailuser'];

} else {

	$usuarioValido ="";
	echo "email vacio";
}*/
 

/* verifica que el usuario y password concuerden correctamente */
//if( $usuarioEnviado == $usuarioValido){
/*esta informacion se envia solo si la validacion es correcta */
//$resultados["mensaje"] = "Validacion Correcta";
//$resultados["validacion"] = "ok";
 
//}else{
/*esta informacion se envia si la validacion falla */
//$resultados["mensaje"] = "Usuario y password incorrectos";
//$resultados["validacion"] = "error";
//}
 
 
/*convierte los resultados a formato json*/
//$resultadosJson = json_encode($resultados);
 
/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
//echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';


?>

