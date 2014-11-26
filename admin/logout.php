<?php
	ob_start();session_start();
	include "../services/config.php";
	include "funciones.php";

	if(isset($_REQUEST['cerrarsesion'])){
                session_destroy();
                header('Location: index.php'); 
            }
?>