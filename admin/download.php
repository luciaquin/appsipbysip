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
                        <li><a href='administrador.php'>Alta Blends</a></li>
                        <li><a href='listado_blends.php'>Ver Blends</a></li>
                        <li><a href='logout.php?cerrarsesion=true'>Log Out</a></li>
                    </ul>
            </nav>
   </header>	

   <div class="exportar">
   <h2>Exportar Emails</h2>
   <p>Seleccione el blend deseado para exportar los emails de los usuarios subcriptos a dicha notificaci&oacute;n.
   Luego, presione "Descargar" y se descargar&aacute; un archivo ".cvs" en la carpeta asignada.</p>
    </div> 

	<?php
       
		//ARMA LOS OPTIONS
        
            $clase->armarOptions();
            echo $clase-> modifBlends;


            
       //PREGUNTO SI ESTA SETEADO EL OPTION ELEGIDO Y EL BTN MODIFICAR, SI ESE ASI DESCARGO TXT
            if(isset($_REQUEST['downloadMe']) && isset($_REQUEST['yourChoice'])){
                $blendElegido = $_REQUEST['yourChoice'];
                //echo "entreeee";
                $clase->downloadTxT($blendElegido);
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