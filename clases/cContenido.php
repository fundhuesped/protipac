<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cContenido
{
	static function getAdjuntosPorTipo($ast_id, $vecStatus, $tadj_id, $trm_id){
		$sql="SELECT lnk_file_full_size, lnk_tadj_id, tadj_carpeta, tadj_descripcion, lnk_fecha_hora_creacion, lnk_id, lnk_caption";
		$sql_from=" FROM link l INNER JOIN tipo_adjunto ta ON (l.lnk_ast_id='$ast_id' AND ta.tadj_id=l.lnk_tadj_id) LEFT JOIN tipo_adjunto_tramite ON (tadjtrm_tadj_id=tadj_id)";
		$sql_where=" WHERE 1";
		if(!empty($vecStatus)){
			$status_asset="";
			for($vi=0;$vi<count($vecStatus);$vi++){
				if($vi>0){
					$status_asset.=",";
				}
				$status_asset.=$vecStatus[$vi];
			}
			if(count($vecStatus)>0){
				$sql_temp=" AND lnk_status IN (|STA|)";
				$sql_where.=str_replace("|STA|", $status_asset, $sql_temp);
			}
		}
		if(!empty($tadj_id)){
			$sql_where.=" AND ta.tadj_id='$tadj_id'";
		}
		if(!empty($trm_id)){
			$sql_where.=" AND tadjtrm_trm_id='$trm_id'";
		}
		$sql_order_by=" ORDER BY lnk_id DESC";
		return cComando::consultar($sql.$sql_from.$sql_where.$sql_order_by);
	}

	static function eliminar($id_contenido)
	{
		$sql = "UPDATE asset SET ast_status=".ST_BLOQUEADO." WHERE ast_id='$id_contenido'";
		cComando::ejecutar($sql, UPDATE, $id);
		return;
	}

	static function GuardarAsset($id_usuario, $id_tipo, $titulo="", $descripcion="", $estado)
	{
		$sql="INSERT INTO asset (ast_title, ast_description, ast_type, ast_status, ast_dateCreated, ast_creator_usr_id, ast_timeCreated, ip, ast_dateModified, ast_timeModified) VALUES ('".addslashes($titulo)."', '".addslashes($descripcion)."', ".$id_tipo.", ".$estado.", '".date("Y-m-d")."', $id_usuario, '".date("H:i:s")."', '".$_SERVER['REMOTE_ADDR']."', '".date("Y-m-d")."', '".date("H:i:s")."')";
		$status = cComando::ejecutar($sql, INSERT, $id);
		if($status!==TRUE){
			return -1;
		} else {
			return $id;
		}
	}

	static function ModificarAsset($id_contenido, $descripcion="", $titulo="", $ast_status="")
	{
		$sql="UPDATE asset SET 
		ast_dateModified='".date("Ymd")."', 
		ast_title='".addslashes(strip_tags($titulo))."',
		ast_description='".addslashes($descripcion)."',
		ast_timeModified='".date("H:i")."', 
		ast_usr_id_modified=".$_SESSION['id_usu'];
		if(!empty($ast_status)){
			$sql.=", ast_status='$ast_status' ";
		}
		$sql.=" WHERE ast_id=$id_contenido";
		$status = cComando::ejecutar($sql, UPDATE, $id);
	}
	
	static function cambiarEstado($campo, $tabla, $campo_id, $estado, $campo_estado)
	{
		$sql="UPDATE asset, ".$tabla." SET ast_status='$estado', ".$campo_estado."='$estado' WHERE ast_id=".$tabla.".".$campo." AND ".$tabla.".".$campo."=$campo_id";
		$status = cComando::ejecutar($sql, UPDATE, $id);
		$sql="SELECT * FROM ".$tabla." WHERE ".$tabla.".".$campo."=".$campo_id;
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad()==0){
			$sql="UPDATE asset SET ast_status='$estado' WHERE ast_id=$campo_id";
			$status = cComando::ejecutar($sql, UPDATE, $id);
		}
		return $id;
	}
	
	
	static function getAssetTypeByAssetId($ast_id)
	{
		$sql="SELECT ast_type FROM asset WHERE ast_id=$ast_id";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			return $rDatos->campo('ast_type', 0);
		}
	}
}

?>