<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cVisitaNombre
{
	static function obtenerCombo(){
		$sql="SELECT crvn_id, crvn_descripcion FROM cronograma_visita_nombre ORDER BY crvn_orden";
		return cComando::consultar($sql);
	}
	static function insertarNombreVisita($descripcion_nombre, $estado_nombre)
	{
		$sql = "SELECT crvn_id FROM cronograma_visita_nombre WHERE crvn_descripcion= '$descripcion_nombre'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0){
			return $rDatos->campo('crvn_id',0);
		}
		
		$sql="INSERT INTO cronograma_visita_nombre (crvn_descripcion,crvn_status,crvn_orden) VALUES ('".addslashes($crvn_descripcion)."', '".addslashes($estado_nombre)."',(SELECT MAX(crvn_orden) FROM cronograma_visita_nombre))";
		$status = cComando::ejecutar($sql, INSERT, $id_crvn);
		if($status==FALSE){
			return -1;
		}
		return $id_crvn;
	}

}
?>