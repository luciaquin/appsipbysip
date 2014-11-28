<?php
//creo la sesion
   ob_start();session_start();
	include "../../services/config.php";
	include "funciones.php";
    $clase = new Funciones();
    $clase -> conexion($dbhost,$dbuser,$dbpass,$dbname);
	if(!isset($_SESSION['usuarioFinal'])){
		header('Location: index.php');
	}else{
		echo "Administrador Loggeado: " . $_SESSION['usuarioFinal'];
	}
?>  

<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="../css/admin_estilos.css" rel="stylesheet"></link>
	<title>APP - Admin</title>
</head>

<body>

	<header>
			<nav>
                    <ul>
                        <li><a href='listado_blends.php'>Ver Blends</a></li>
                        <li><a href='download.php'>Exportar Emails</a></li>
                        <li><a href='logout.php?cerrarsesion=true'>Log Out</a></li>
                    </ul>
            </nav>
   </header>	

     <h2>Alta Blends</h2>          
        <p>Por favor complete los datos, luego pulse el boton "Upload" para realizar la carga.</p>
        <div class="admin">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <label>Titulo:</label>
            <input class="alta" type="text" name="blend"/>
            <label >Precio:</label>
            <input class="precio" type="text" name="precio"/><br />
            <label>Descripci&oacute;n:</label>
            <textarea name="descripcion"></textarea>
        <legend>Subir Imagen</legend>
        <p>Elija una imagen para subir, luego pulse "upload"</p>
        <input type="file" name="files[]" accept="image/*">
        <input name="photoUploadForm" type="submit" value="Upload">
    </form>
    </div>

    <?php
       //ALTA DEL LISTADO DE BLENDS
       if(isset($_REQUEST['blend']) && isset($_REQUEST['precio']) && isset($_REQUEST['descripcion']) && isset($_POST['photoUploadForm'])){
                        $blend = $_REQUEST['blend'];
                        $precio = $_REQUEST['precio'];
                        $descripcion = $_REQUEST['descripcion'];

                        $clase->altaBlends($blend,$precio,$descripcion);
        }

        
            /* ======================================= */
            /*              CERRAR SESION              */
            /* ======================================= */
            if(isset($_REQUEST['cerrarsesion'])){
                header('Location: logout.php'); 
            }

?>

    </body>

</html>