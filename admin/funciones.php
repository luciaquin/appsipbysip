<?php
	include "../services/config.php";

	Class Funciones{

		public $dbhost;
		public $dbuser;
		public $dbpass;
		public $dbname;
		public $mysqli;

    public $modifBlends;

		
		public function conexion($s, $u, $p, $db){

			$this -> dbhost = $s;
			$this -> dbuser = $u;
			$this -> dbpass = $p;   /* asigno valores */
			$this -> dbname = $db;

			$this -> mysqli = new mysqli($this -> dbhost, $this -> dbuser, $this -> dbpass, $this -> dbname); /* esta es la conexion */

			if ($this ->mysqli -> connect_errno){  /*si hay un error de conexion, imprimo en pantalla */
				echo "Error en la conexion con la base de datos. " . $this ->mysqli -> connect_errno;
			}else{
				//echo "Conexion exitosa  ";
			}
		}

		//funcion que selecciona los datos de la tabla admin para crear la sesion
		public function sessionAdmin($user,$pass){
			$resultado = $this->mysqli->query("SELECT * FROM admin WHERE admin = '$user' AND pass = '$pass'");
			if(mysqli_num_rows($resultado) == 1){
					return true;
				}else{
					return false;
				}
			}

		/* ============================================================== */
		/*							           ALTAS								                  */	
		/* ============================================================== */

		//Alta listado blends		
		public function altaBlends($blend,$precio,$descripcion){
				$idImagenUnico = uniqid();
				$resultado = $this -> mysqli->query("INSERT into newblends(id, blend, precio, descripcion, idCodigoImg) VALUES('0','$blend','$precio','$descripcion', '$idImagenUnico')"); 
				$this-> altaFotos("fotoGrande/", "thumbnails/", $crearThumbs = true, $idImagenUnico);
		}		

		//=======================================================================//
		//							         LISTADO BLENDS 								                 //
		//=======================================================================//		
			
			public function listadoBlends(){
				$sql="SELECT * FROM newblends LEFT OUTER JOIN imagenes ON newblends.idCodigoImg = imagenes.idCodigoImg";
				$resultado = $this->mysqli->query($sql);
				$blends = array();
				if($resultado->num_rows){
					$resultado->data_seek(0);		
				while($fila = $resultado -> fetch_assoc()){	
						$blends[] = $fila;
					}
				}						
				return $blends;	
			}	


      /* ============================================================== */
      /*                        BAJAS                                   */  
      /* ============================================================== */    
      
      public function bajaBlend($idBaja, $idCodImg){
        $this-> deleteFoto($idCodImg);
        $eliminar = $this->mysqli->query("DELETE FROM newblends WHERE id = '$idBaja'");
        $eliminarImg = $this-> mysqli-> query("DELETE FROM imagenes WHERE idCodigoImg = '$idCodImg'");
      }

      public function deleteFoto($codigo){
          if($consulta = $this-> mysqli-> query("select ruta, rutaThumb from imagenes where idCodigoImg = '$codigo'")){
            $fila = $consulta-> fetch_assoc();
            $borrarBig = $fila['ruta'];
            $borrarThumb = $fila['rutaThumb'];  
            if(!@unlink($borrarBig)){
            //  echo "No se pudo borrar la imagen grande.";
            }
            if(!@unlink($borrarThumb)){
            //  echo "no se pudo Borrar la imagen chica";
            }
          }else{
            echo "no hay imagen para borrar";
          }
        }

    /* ============================================================== */
    /*                        MODIFICAR                               */  
    /* ============================================================== */    
        
      // trae el formulario de los blends que tiene imagen
      public function modificarTxtBlends($id){ 
       
      }


    //Trae el formulario de los blends que no tiene imagenes  
    public function traeFormModificar($id){
      
  }


/******************************************************************************************************/
/*            								FOTOS                                                     */
/******************************************************************************************************/

        public function altaFotos($pathImageBig, $pathThumbnail, $crearThumbs = true, $idImagenUnico){
            $valid_formats = array("jpg", "png", "gif", "bmp");
              $max_file_size = 1024*1024; //100 kb
              $pathGrande = $pathImageBig;
              $pathOutputThumb = $pathThumbnail;
              $count = 0;
              

          // Loop $_FILES to execute all files
            foreach ($_FILES['files']['name'] as $f => $name) {                                 //$name tiene el nombre del archivo - $path.$name concatena ruta + nombre.
                if ($_FILES['files']['error'][$f] == 4) {
                    $this-> message = "No se subieron archivos.";
                    continue;                                                                     // Skip file if any error found
                }        
                if ($_FILES['files']['error'][$f] == 0) {            
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                          $this-> message = "$name es muy pesado para el server";
                          continue;                                                             // Skip large files
                    }elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                        $this-> message = "$name is not a valid format";
                        continue; // Skip invalid file formats
                      }else{     
                              // No error found! Move uploaded files               

                              $extension = pathinfo($name, PATHINFO_EXTENSION);
                              $name_without_extension = pathinfo($name, PATHINFO_FILENAME);
                            //$re_name = $name_without_extension . "_" . uniqid() . ".".$extension;
                           // $re_name = $name_without_extension . "_" . uniqid();
                            $re_name = $name_without_extension . "_" . $idImagenUnico;
                            $nameThumb = $re_name . "_thumbnail." . $extension;
                            $re_name .=  ".".$extension;
                            $rutaFinalGrande = $pathGrande.$re_name;
                            $rutaOutputThumbnail = $pathOutputThumb.$nameThumb;

                            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $rutaFinalGrande)){
                                $this-> message = "Carga con exito. La img ya se movio al server. <br /> El nombre es: ".$name ."<br />".
                                "El nombre en el server es: " . $re_name . "<br />".
                                "La ruta final de la image es: " . $rutaFinalGrande;                                
                                //Llamo a la funcion THUMNAILS!        
                                if($crearThumbs){
                                    //$this-> creaThumbs($rutaFinalGrande,310, 217, $rutaOutputThumbnail);
                                    $this-> creaThumbs($rutaFinalGrande,160, 160, $rutaOutputThumbnail, $keep_ratio = true);
                                }else{
                                    $nameThumb = $rutaOutputThumbnail = "Thumbnail deshabilitado";
                                }                                                        
                                  $count++; // Number of successfully uploaded file

                                  $sql = "INSERT into imagenes(idimg, idCodigoImg, nombre, renombre, extension, ruta, nombreThumb, rutaThumb) values('0', '$idImagenUnico', '$name', '$re_name', '$extension', '$rutaFinalGrande', '$nameThumb', '$rutaOutputThumbnail')";
                                 // echo $sql;
                                  if($consulta = $this-> mysqli-> query($sql)){
                                      $this-> respuesta = "Img agregada a la db";

                                      //¡¡¡¡¡¡No pongo return porque me corta el proceso a la primer carga exitosa. SI son varias imgs, carga la 1era y muere!!!!!
                                }else{
                                      $respuesta = "Algun problema ocurrio al guardar en la db las IMGs, cortamos la carga.";
                                      return false;
                                }
                            }                        
                        }
                   }
              }  
              return true;       //Se cargaron los archivos, despues de hacer el bucle.
        }
        //Crea imagenes pequeñas por cada imagen subida al server.
        public function creaThumbs($url, $width, $height, $url_out, $keep_ratio = false){
            if($height <= 0 && $width <= 0)
                return false;
            else{
                copy($url, $url_out);
                $info = getimagesize($url);
                $image = '';
                $final_width = 0;
                $final_height = 0;
                // list() se usa para asignar valores en una sola operacion.
                //Esta asignando los valores de la imagen original, valores "viejos", de referencia para el thumb.
                list($width_old, $height_old) = $info;
                if($keep_ratio){
                    if($width == 0)
                        $factor = $height/$height_old;
                      elseif($height == 0)
                        $factor = $width/$width_old;
                      else
                        $factor = min($width / $width_old, $height / $height_old);
                        $final_width = round( $width_old * $factor );
                        $final_height = round( $height_old * $factor );
                }else{
                    $final_width = ($width <= 0) ? $width_old : $width;
                    $final_height = ($height <= 0) ? $height_old : $height;
                }
                switch($info[2]){
                    case IMAGETYPE_GIF:
                        $image = imagecreatefromgif($url_out);
                        break;
                      case IMAGETYPE_JPEG:
                        $image = imagecreatefromjpeg($url_out);
                        break;
                      case IMAGETYPE_PNG:
                        $image = imagecreatefrompng($url_out);
                        break;
                      default:
                        return false;
                }
                $image_resized = imagecreatetruecolor($final_width, $final_height);
                if($info[2] == IMAGETYPE_GIF || $info[2] == IMAGETYPE_PNG){
                    $transparency = imagecolortransparent($image);
                    if($transparency >= 0){
                        $transparent_color = imagecolorsforindex($image, $trnprt_indx);
                        $transparency = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                        imagefill($image_resized, 0, 0, $transparency);
                        imagecolortransparent($image_resized, $transparency);
                      }elseif($info[2] == IMAGETYPE_PNG){
                        imagealphablending($image_resized, false);
                        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                        imagefill($image_resized, 0, 0, $color);
                        imagesavealpha($image_resized, true);
                      }
                }
                imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
                switch($info[2]){
                      case IMAGETYPE_GIF:
                        imagegif($image_resized, $url_out);
                        break;
                      case IMAGETYPE_JPEG:
                        imagejpeg($image_resized, $url_out);
                        break;
                      case IMAGETYPE_PNG:
                        imagepng($image_resized, $url_out);
                        break;
                      default:
                        return false;
                }
                imagedestroy($image_resized);
                return true;
            }
        }			
}			