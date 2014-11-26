<?php
//creo la sesion
ob_start();session_start();
include "../services/config.php";
include "funciones.php";
?>

<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>APP - Admin - Login</title>
</head>

<body>
	<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
		<h1>Log in - Administrador</h1>
		<label>Usuario:</label>
		<input type="text" name="userAdmin">
		<label>Contrase&ntilde;a:</label>
		<input type="password" name="passAdmin">
		<input type="submit" value="Enviar">
	</form>

	<?php
		if(isset($_REQUEST['userAdmin']) && isset($_REQUEST['passAdmin'])){
                  		$admin = $_REQUEST['userAdmin'];
						$pass = $_REQUEST['passAdmin'];
						$clase = new Funciones();
						$clase -> conexion($dbhost,$dbuser,$dbpass,$dbname);
						if($clase -> sessionAdmin($admin,$pass)){
							$_SESSION['usuarioFinal'] = $admin;
							header('Location: administrador.php'); 
			  				exit();
						}else{
							echo "Error al ingresar los datos";
						}

		}
	?>
</body>

</html>