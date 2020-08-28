<?php
incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);
//incluir('clases/thumbnail.inc.php',  $_SERVER['SCRIPT_NAME']);

class cImagen
{
	static function getSizeToShow($imagen, $anchoshow, $altoshow)
	{
		list($width, $height, $type, $attr) = getimagesize($imagen);
		if($width>$anchoshow || $height>$altoshow){
			$divancho=$anchoshow/$width;
			$divalto=$altoshow/$height;
			//if($height>$width){
					$factor=$width/$height;
					if(ceil($altoshow*$factor)<=$anchoshow){
						$tamano="width=".ceil($altoshow*$factor)." height=".$altoshow;
					} else {
						$tamano="width=".$anchoshow." height=".ceil($anchoshow/$factor);
					}
			/*} else {
				if($height==$width){
					$tamano="width=".$anchoshow." height=".$anchoshow;				
				} else {
					if($height*$divancho<=$altoshow){
						$tamano="width=".$anchoshow." height=".intval($height*$divancho);
					}
					
					if($width*$divalto<=$anchoshow){
						$tamano="width=".intval($width*$divancho)." height=".$altoshow;
					}
				}
			}*/
		} else {
			$tamano="width=".$width." height=".$height;
		}
		return $tamano;
	}
	
	static function GuardarImagen($imagen)
	{
		if(is_array($imagen))
		{
			if(is_uploaded_file($imagen['tmp_name'])){
				list($width, $height, $type, $attr) = getimagesize($imagen['tmp_name']);
				if($imagen['type']=="image/pjpeg" || $imagen['type']=="image/jpeg" || $imagen['type']=="image/png" || $imagen['type']=="image/gif"){
					if($imagen['size']<SIZEIMAGEN){
						if(!is_dir(PATH.imagenestemp)){
							mkdir(PATH.imagenestemp);
						}
						$aAux = explode('.', $imagen['name']);
						$extension = $aAux[count($aAux) - 1];
						$nombre_archivo = $_SESSION['id_usu'] . "_" . date("Ymd") . "_". date("His") . "_" . "temp" . "." . $extension;
						move_uploaded_file($imagen['tmp_name'], PATH.imagenestemp.BARRA.$nombre_archivo);
							/*$thumb = new Thumbnail;
							$thumb->fileName = PATH.imagenestemp.BARRA.$nombre_archivo;
							$thumb->init();
							$thumb->quality = 80;
							$thumb->percent = 0;
							$difAncho=ANCHOIMG-$width;
							$difAlto=ALTOIMG-$height;

							if($difAlto-$difAncho<0){
								$thumb->maxHeight = ALTOIMG;
							} else {
								$thumb->maxWidth = ANCHOIMG;						
							}
							if($width>ANCHOIMG || $height>ALTOIMG){
								$thumb->resize();
							}
							$thumb->save(PATH.imagenestemp.BARRA.$nombre_archivo);
							//$thumb->destruct();
							*/
						return $nombre_archivo;
					} else {
						//se excede el tamaño máximo
						return -3;
					}
				} else {
					//No coincide el tipo de imagen
					return -1;			
				}
			} else {
				//la imágen no pudo ser subida
				return -2;
			}
		}
	}

	static function GuardarImagenMember($imagen)
	{
		if(is_array($imagen))
		{
			if(is_uploaded_file($imagen['tmp_name'])){
				list($width, $height, $type, $attr) = getimagesize($imagen['tmp_name']);
				if($imagen['type']=="image/pjpeg" || $imagen['type']=="image/jpeg" || $imagen['type']=="image/png" || $imagen['type']=="image/gif"){
					if($imagen['size']<SIZEIMAGEN){
						if(!is_dir(PATH.imagenestemp)){
							mkdir(PATH.imagenestemp);
						}
						error_reporting(E_ALL);
						ini_set("display_errors", "On");
						$aAux = explode('.', $imagen['name']);
						$extension = $aAux[count($aAux) - 1];
						$nombre_archivo = session_id() . "_" . date("Ymd") . "_". date("His") . "_" . "temp" . "." . $extension;
						move_uploaded_file($imagen['tmp_name'], PATH.imagenestemp.BARRA.$nombre_archivo);
						//if($width>ANCHOIMG){
							$thumb = new Thumbnail;
							$thumb->fileName = PATH.imagenestemp.BARRA.$nombre_archivo;
							$thumb->init();
							$thumb->quality = 80;
							$thumb->percent = 0;
							$difAncho=ANCHOIMG-$width;
							$difAlto=ALTOIMG-$height;
							/*if($difAncho<0){
								$difAncho=$difAncho*(-1);
							}
							if($difAlto<0){
								$difAlto=$difAlto*(-1);
							}*/
							if($difAlto-$difAncho<0){
								$thumb->maxHeight = ALTOIMG;
							} else {
								$thumb->maxWidth = ANCHOIMG;						
							}
							if($width>ANCHOIMG || $height>ALTOIMG){
								$thumb->resize();
							}
							$thumb->save(PATH.imagenestemp.BARRA.$nombre_archivo);
							//$thumb->destruct();
						//}
						return $nombre_archivo;
					} else {
						//se excede el tamaño máximo
						return -3;
					}
				} else {
					//No coincide el tipo de imagen
					return -1;			
				}
			} else {
				//la imágen no pudo ser subida
				return -2;
			}
		}
	}


	static function GuardarAdjunto($adjunto)
	{
		if(is_array($adjunto))
		{
			if(is_uploaded_file($adjunto['tmp_name'])){
					if($adjunto['size']<SIZEIMAGEN){
						if(!is_dir(PATH.imagenestemp)){
							mkdir(PATH.imagenestemp);
						}
						$aAux = explode('.', $adjunto['name']);
						$extension = $aAux[count($aAux) - 1];
						$nombre_archivo = $_SESSION['id_usu'] . "_" . date("Ymd") . "_". date("His") . "_" . "temp" . "." . strtolower($extension);
						//$mimetype = mime_content_type($adjunto['tmp_name']);
						//if(in_array($mimetype, array('image/jpeg', 'image/gif', 'image/png', 'application/pdf', 'application/msword', 'application/rtf'))) {
							move_uploaded_file($adjunto['tmp_name'], PATH.imagenestemp.BARRA.$nombre_archivo);
						//} else {
							//formato incorrecto
							//$return -1;
						//}
						return $nombre_archivo;
					} else {
						//se excede el tamaño máximo
						return -3;
					}
			} else {
				//el adjunto no pudo ser subido
				return -2;
			}
		}
	}


	static function BloquearLinkAsset($id_contenido, $lnk_id)
	{
		$sql = "SELECT lnk_file_full_size FROM link WHERE lnk_file_full_size='".$nombre_archivo."'";
		$rDatos = cComando::consultar($sql);
	
		if($rDatos->cantidad()==0){
			$path=$path.BARRA.$nombre_archivo;
			unlink($path);
		}
	}

	static function BorrarImagen($nombre_archivo, $path)
	{
		$sql = "SELECT lnk_file_full_size FROM link WHERE lnk_file_full_size='".$nombre_archivo."'";
		$rDatos = cComando::consultar($sql);
	
		if($rDatos->cantidad()==0){
			$path=$path.BARRA.$nombre_archivo;
			unlink($path);
		}
	}
	

	static function BorrarAdjuntoTemporal($nombre_archivo, $path)
	{
		$path=$path.BARRA.$nombre_archivo;
		if(file_exists($path)){
			unlink($path);
		}
	}
	
	static function BorrarImagenTemporal($nombre_archivo, $path)
	{
		$path=$path.BARRA.$nombre_archivo;
		if(file_exists($path)){
			unlink($path);
		}
	}
	
	static function GetImagenById($nombre_archivo)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT link.lnk_id, link.lnk_caption FROM link WHERE lnk_file_thumb_size='".$nombre_archivo."'";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}

	static function SalvarVinculo($id_contenido, $id_usuario_modifica, $adjunto, $caption, $estado)
	{
		if(strlen($id_contenido)){
			$sql="INSERT INTO link (lnk_ast_id, lnk_file_full_size, lnk_file_thumb_size, lnk_caption, lnk_status, ip, lnk_type, fecha_modificado, hora_modificado, lnk_usr_id_modified) VALUES ($id_contenido, '$adjunto', '', '".addslashes($caption)."', '".$estado."', '".$_SERVER['REMOTE_ADDR']."', '".LINKDOC."','".date("Ymd")."', '".date("H:i")."', ".$id_usuario_modifica.")";
		}
		$status = cComando::ejecutar($sql, INSERT, $id);
	}
	
	
	static function SalvarAdjunto($id_contenido, $pathAdjunto, $id_usuario_modifica, $adjunto, $caption, $id_carpeta, $estado)
	{
		if(!is_dir(PATH.$pathAdjunto.BARRA.$id_carpeta)){
			mkdir(PATH.$pathAdjunto.BARRA.$id_carpeta);
		}
		$nuevo_adjunto=str_replace("_temp", "", $adjunto);
		rename(PATH.imagenestemp.BARRA.$adjunto, PATH.$pathAdjunto.BARRA.$id_carpeta.BARRA.$nuevo_adjunto);
		if(strlen($id_contenido)){
			$sql="INSERT INTO link (lnk_ast_id, lnk_file_full_size, lnk_file_thumb_size, lnk_caption, lnk_status, ip, lnk_type, fecha_modificado, hora_modificado, lnk_usr_id_modified, lnk_ext) VALUES ($id_contenido, '$nuevo_adjunto', '".str_replace(".", "_thumb.", strtolower($nuevo_adjunto))."', '".addslashes($caption)."', '".$estado."', '".$_SERVER['REMOTE_ADDR']."', '".ATTACHDOC."','".date("Ymd")."', '".date("H:i")."', ".$id_usuario_modifica.",'".strtoupper(substr($nuevo_adjunto,strlen($nuevo_adjunto)-3))."')";
		}
		$status = cComando::ejecutar($sql, INSERT, $id);
	}
	
	static function SalvarAdjuntoCustom($ast_id, $pathAdjunto, $adjunto,$carpeta,$caption,$estado, $tipo_link,$id_usuario_crea,$tipo_adjunto)
	{
		if(!is_dir(PATH.$pathAdjunto.BARRA.$ast_id)){
				mkdir(PATH.$pathAdjunto.BARRA.$ast_id);
		}
		if(!is_dir(PATH.$pathAdjunto.BARRA.$ast_id.BARRA.$carpeta)){
			if(!is_dir(PATH.$pathAdjunto.BARRA.$ast_id.BARRA.$carpeta)){
				mkdir(PATH.$pathAdjunto.BARRA.$ast_id.BARRA.$carpeta);
			}			
			mkdir(PATH.$pathAdjunto.BARRA.$ast_id.BARRA.$carpeta);
		}
		$nuevo_adjunto=str_replace("_temp", "", $adjunto);
		$res=rename(PATH.imagenestemp.BARRA.$adjunto, PATH.$pathAdjunto.BARRA.$ast_id.BARRA.$carpeta.BARRA.strtolower($nuevo_adjunto));
		$sql="INSERT INTO link (lnk_ast_id,lnk_tadj_id, lnk_file_full_size, lnk_file_thumb_size, lnk_caption, lnk_status, ip, lnk_type, lnk_fecha_hora_modificado, lnk_fecha_hora_creacion, lnk_usr_id_modified, lnk_usr_id_creacion, lnk_ext) VALUES ('$ast_id', '$tipo_adjunto', '$nuevo_adjunto', '', '".addslashes($caption)."', '".$estado."', '".$_SERVER['REMOTE_ADDR']."', '".$tipo_link."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."', ".$id_usuario_crea.", '".$id_usuario_crea."','".strtoupper(substr($nuevo_adjunto,strlen($nuevo_adjunto)-3))."')";
		$status = cComando::ejecutar($sql, INSERT, $id);
		if($res && $status){
			return true;
		} else {
			return false;
		}
	}
	static function DesactivarAdjuntoCustom($lnk_id, $estado,$usr_modifica){
		$sql = "UPDATE link SET lnk_status='$estado', lnk_fecha_hora_modificado='".date("Y-m-d H:i:s")."', lnk_usr_id_modified='$usr_modifica' WHERE lnk_id='$lnk_id'";
		$status = cComando::ejecutar($sql, UPDATE, $id);
	}
	static function SalvarImagen($id_contenido, $pathImagen, $id_usuario_modifica, $imagen, $caption, $id_carpeta, $estado)
	{
		if(!is_dir(PATH.$pathImagen.BARRA.$id_carpeta)){
			mkdir(PATH.$pathImagen.BARRA.$id_carpeta);
		}
		$nueva_imagen=str_replace("_temp", "", $imagen);
		rename(PATH.imagenestemp.BARRA.$imagen, PATH.$pathImagen.BARRA.$id_carpeta.BARRA.$nueva_imagen);
		list($width, $height, $type, $attr) = getimagesize(PATH.$pathImagen.BARRA.$id_carpeta.BARRA.$nueva_imagen);
		//if($width>ANCHOTHUMB){
			$thumb = new Thumbnail;
			$thumb->fileName = PATH.$pathImagen.BARRA.$id_carpeta.BARRA.$nueva_imagen;
			$thumb->init();
			$thumb->quality = 80;
			$thumb->percent = 0;
			$difAncho=ANCHOTHUMB-$width;
			$difAlto=ALTOTHUMB-$height;
			/*if($difAncho<0){
				$difAncho=$difAncho*(-1);
			}
			if($difAlto<0){
				$difAlto=$difAlto*(-1);
			}*/
			if($difAlto-$difAncho<0){
				$thumb->maxHeight = ALTOTHUMB;
			} else {
				$thumb->maxWidth = ANCHOTHUMB;						
			}
			if($width>ANCHOTHUMB || $height>ALTOTHUMB){
				$thumb->resize();
			}
			
			$thumb->save(PATH.$pathImagen.BARRA.$id_carpeta.BARRA.str_replace(".", "_thumb.", strtolower($nueva_imagen)));
		//}
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		if(strlen($id_contenido)){
			$sql="INSERT INTO link (lnk_ast_id, lnk_file_full_size, lnk_file_thumb_size, lnk_caption, lnk_status, ip, lnk_type, fecha_modificado, hora_modificado, lnk_usr_id_modified, lnk_ext) VALUES ($id_contenido, '$nueva_imagen', '".str_replace(".", "_thumb.", strtolower($nueva_imagen))."', '".addslashes($caption)."', '".$estado."', '".$_SERVER['REMOTE_ADDR']."', '".IMGDOC."','".date("Ymd")."', '".date("H:i")."', ".$id_usuario_modifica.",'".strtoupper(substr($nueva_imagen,strlen($nueva_imagen)-3))."')";
			$status = cComando::ejecutar($sql, INSERT, $id);
		}
		//cDB::cerrar();
	}




	
	static function GuardarImagenFileSystem($pathImagen, $imagen, $ancho, $alto, $anchothumb="", $altothumb="", $thumb)
	{
		if(!is_dir(PATH.$pathImagen)){
			mkdir(PATH.$pathImagen);
		}
		$nueva_imagen=str_replace("_temp", "", $imagen);
		
		
		$thumb = new Thumbnail;
		/*resize original*/
		$thumb->fileName = PATH.imagenestemp.BARRA.$imagen;
		$thumb->init();
		$thumb->quality = 80;
		$thumb->percent = 0;
		$difAncho=$ancho-$width;
		$difAlto=$alto-$height;

		if($difAlto-$difAncho<0){
			$thumb->maxHeight = $alto;
		} else {
			$thumb->maxWidth = $ancho;						
		}
		if($width>$ancho || $height>$alto){
			$thumb->resize();
		}
		$thumb->save(PATH.imagenestemp.BARRA.$imagen);
		
		rename(PATH.imagenestemp.BARRA.$imagen, PATH.$pathImagen.BARRA.$nueva_imagen);

		
		list($width, $height, $type, $attr) = getimagesize(PATH.$pathImagen.BARRA.$id_usuario.BARRA.$nueva_imagen);
		
		if($thumb=="S"){
			$thumb = new Thumbnail;
			$thumb->fileName = PATH.$pathImagen.BARRA.$nueva_imagen;
			$thumb->init();
			$thumb->quality = 80;
			$thumb->percent = 0;
			$difAncho=$anchothumb-$width;
			$difAlto=$altothumb-$height;
			if($difAlto-$difAncho<0){
				$thumb->maxHeight = $altothumb;
			} else {
				$thumb->maxWidth = $anchothumb;						
			}
			if($width>$anchothumb || $height>$altothumb){
				$thumb->resize();
			}
			$thumb->save(PATH.$pathImagen.BARRA.str_replace(".jpg", "_thumb.jpg", strtolower($nueva_imagen)));
		}
		$status = cComando::ejecutar($sql, INSERT, $id);
	}
	
	static function GetLink($id_contenido, $id_tipo)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT link.lnk_file_full_size, link.lnk_file_thumb_size, link.lnk_caption, lnk_id, lnk_status FROM link WHERE lnk_ast_id=$id_contenido AND lnk_type=$id_tipo ORDER BY lnk_id";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function GetTotalImagenes($id_contenido)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT link.lnk_file_full_size as imagen_full, link.lnk_file_thumb_size as imagen_thumb, link.lnk_caption as caption, link.lnk_id FROM link WHERE link.lnk_ast_id=$id_contenido";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function GetImagenUsuario($id_usuario)
	{
		$sql = "SELECT link.lnk_file_full_size as imagen_full, link.lnk_file_thumb_size as imagen_thumb, link.lnk_caption as caption, link.lnk_id FROM link, asset, user WHERE link.lnk_ast_id=asset.ast_id AND asset.ast_id=user.usr_ast_id AND user.usr_id=$id_usuario AND link.lnk_status<>'".ST_BLOQUEADO."' AND link.lnk_status<>'".ST_CANCELADO_USUARIO."' AND ast_type=".USUARIO.' AND lnk_type='.IMGDOC;
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}

	static function GetPrimeraImagen($id_contenido)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT lnk_file_thumb_size FROM link WHERE lnk_ast_id=$id_contenido AND lnk_status<>'C' AND lnk_status<>'N' ORDER BY lnk_id";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function DesactivarImagen($id_foto, $id_contenido){
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "UPDATE link SET lnk_status='C', fecha_modificado='".date("Ymd")."', hora_modificado='".date("H:i")."', lnk_usr_id_modified=".$_SESSION['id_usu']." WHERE lnk_id=".$id_foto." AND lnk_ast_id=".$id_contenido;
		$status = cComando::ejecutar($sql, UPDATE, $id);
		//cDB::cerrar();
	}

	static function DesactivarImagenesBorradas($id_foto, $id_contenido, $vec, $id_tipo){
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "UPDATE link SET lnk_status=".ST_CANCELADO_USUARIO.", fecha_modificado='".date("Ymd")."', hora_modificado='".date("H:i")."', lnk_usr_id_modified=".$_SESSION['id_usu']." WHERE lnk_ast_id=".$id_contenido." AND lnk_status<>".ST_CANCELADO_USUARIO." AND lnk_type=$id_tipo";
		$valores="";
		for($k=0;$k<count($vec);$k++){
			$valores.=$vec[$k];
			if($k<(count($vec)-1)){
				$valores.=",";
			}
		}
		if(count($vec)>0){
			$sql.=" AND lnk_id NOT IN (".$valores.") ";
		}
		$status = cComando::ejecutar($sql, UPDATE, $id);
		//cDB::cerrar();
	}
	static function ModificarLink($link_id, $estado){
		$sql="UPDATE link SET lnk_status=$estado WHERE lnk_id=$link_id";
		$status = cComando::ejecutar($sql, UPDATE, $id);
	}								
	static function DesactivarImagenUsuario($id_foto, $id_contenido){
		$sql = "UPDATE link SET lnk_status='".ST_CANCELADO_USUARIO."', fecha_modificado='".date("Ymd")."', hora_modificado='".date("H:i")."', lnk_usr_id_modified=".$_SESSION['id_usu']." WHERE lnk_id=".$id_foto." AND lnk_ast_id=".$id_contenido;
		$status = cComando::ejecutar($sql, UPDATE, $id);
	}	
	static function ModificarCaption($id_foto, $descripcion, $id_contenido){
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "UPDATE link SET lnk_caption='".addslashes($descripcion)."', fecha_modificado='".date("Ymd")."', hora_modificado='".date("H:i")."', lnk_usr_id_modified=".$_SESSION['id_usu']." WHERE lnk_id=".$id_foto." AND lnk_ast_id=".$id_contenido;
		$status = cComando::ejecutar($sql, UPDATE, $id);
		//cDB::cerrar();
	}	
	static function ModificarCaptionUsuario($id_foto, $descripcion, $id_contenido){
		$sql = "UPDATE link SET lnk_caption='".addslashes($descripcion)."', fecha_modificado='".date("Ymd")."', hora_modificado='".date("H:i")."', lnk_usr_id_modified=".$_SESSION['id_usu']." WHERE lnk_id=".$id_foto." AND lnk_ast_id=".$id_contenido;
		$status = cComando::ejecutar($sql, UPDATE, $id);
	}	
	static function EliminarImagen($id_foto, $path, $id_contenido)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT lnk_file_full_size, lnk_file_thumb_size, lnk_type FROM link WHERE lnk_id=".$id_foto." AND lnk_ast_id=".$id_contenido;
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad()!=0){
			echo($rDatos->campo('lnk_type', 0));
			if($rDatos->campo('lnk_type', 0)==IMGDOC || $rDatos->campo('lnk_type', 0)==ATTACHDOC){
				$camino=PATH.BARRA.$path.BARRA.$rDatos->campo('lnk_file_full_size',0);
				unlink($camino);
				$camino=PATH.BARRA.$path.BARRA.$rDatos->campo('lnk_file_thumb_size',0);
				unlink($camino);
			}
			$sql = "DELETE FROM link WHERE lnk_id=".$id_foto." AND lnk_ast_id=".$id_contenido;
			$status = cComando::ejecutar($sql, DELETE, $id);
		}
		//cDB::cerrar();
	}
	static function obtenerPorId($id_contenido, $id_link){
		$sql="SELECT * FROM link, asset WHERE ast_id=lnk_ast_id AND lnk_id=$id_link AND lnk_ast_id=$id_contenido";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
}
?>