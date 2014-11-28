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
    
    <script>
        function confirmSubmit()
        {
            if (confirm('Seguro que quiere eliminar este registro?'))
            {
                return true;
            }
            return false;
        }
    </script>
</head>

<body>

	<header>
			<nav>
                    <ul>
                        <li><a href='administrador.php'>Alta Blends</a></li>
                        <li><a href='download.php'>Exportar Emails</a></li>
                        <li><a href='logout.php?cerrarsesion=true'>Log Out</a></li>
                    </ul>
            </nav>
   </header>	

     <h2>Listado de Blends</h2>          
        <p>Este es el listado de los nuevos blends. Para modificar o eliminar un registro, pulse el link correspondiente y aplique los
                	cambios. Luego pulse "Enviar".</p>
        
	<?php
       
		$resultado = $clase -> listadoBlends();
        if(empty($resultado)){
            echo "No hay blends en la base de datos.";
        }else{
            echo "<table border='1'><tr><th>Listado Blends</th></tr>";
            echo "<tr>
                    <th>Blend</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Eliminar</th>
                    <th>Modificar</th>
                </tr>";
                foreach ($resultado as $blend) {
                echo "<tr>";
                echo "<td>" . $blend["blend"] . "</td>";
                echo "<td>" . $blend["descripcion"] . "</td>";
                echo "<td>" . $blend["precio"] . "</td>";
                if($blend['idCodigoImg'] == $blend['idCodigoImg']){
                    echo "<td><img src='" . $blend["rutaThumb"] . "' alt=". $blend['blend'] ."</td>";
                }else{
                    echo "<td>sin imagen</td>";
                }
                echo "<td><a href='http://sip-by-sip.info/www/admin/listado_blends.php?idBaja=$blend[id]&idCodImg=$blend[idCodigoImg]' onclick='return confirmSubmit();'>Eliminar</a></td>";
                echo "<td><a href='http://sip-by-sip.info/www/admin/listado_blends.php?idModificar=$blend[id]&idCodImg=$blend[idCodigoImg]'>Modificar</a></td>";      
                echo "</tr>";
            }
                echo "</table>";
            }


          //BAJA DE LOS BLENDS
            if(isset($_REQUEST['idBaja']) && isset($_REQUEST['idCodImg'])){
                $idBaja = $_REQUEST['idBaja'];
                $idCodImg = $_REQUEST['idCodImg'];
                $clase->bajaBlend($idBaja, $idCodImg);
            }

            //MODIFICAR BLENDS
            if(isset($_REQUEST['idModificar']) && isset($_REQUEST['idCodImg'])){
                $clase-> modificarBlends($_REQUEST['idModificar'], $_REQUEST['idCodImg']);
                echo $clase-> modifBlends;
            }

            //UPDATE BLENDS
            


         if(isset($_REQUEST['modificarBoton']) && isset($_FILES['files']) 
            && isset($_REQUEST['modifNombre']) && isset($_REQUEST['modifPrecio']) 
            && isset($_REQUEST['modifDescripcion'])){


                $id = $_REQUEST['id'];
                $idCodImgActual = $_REQUEST['codImg'];
                $nombre = $_REQUEST['modifNombre'];
                $precio = $_REQUEST['modifPrecio'];
                $descripcion = $_REQUEST['modifDescripcion'];
                $clase-> cambiarImagen($id, $nombre, $precio, $descripcion);
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