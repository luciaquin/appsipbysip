<?php
//creo la sesion
ob_start();session_start();
include "../../services/config.php";
include "funciones.php";
?>

<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="../css/admin_estilos.css" rel="stylesheet"></link>
	<title>APP - Admin - Login</title>

</head>

<body>
	<div class="contenedor_form">
	<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
		<h1>Log in - Administrador</h1>
		<label class="index" id="usr">Usuario:</label>
		<input class="index" type="text" name="userAdmin" placeholder="usuario administrador">
		<label class="index">Contrase&ntilde;a:</label>
		<input class="index" type="password" name="passAdmin" placeholder="ingresar contrase&ntilde;a">
		<input class="btnindex" type="submit" value="Entrar" >
	</form>
	</div>

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